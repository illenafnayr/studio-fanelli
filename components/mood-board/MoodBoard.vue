<template>
    <div class="mood-board" ref="moodBoard">
        <h2 v-if="!isMobileDevice && !isEditing" class="mood-board-title" @dblclick="isEditing = true">{{ title }}</h2>
        <input v-if="isMobileDevice || isEditing" class="mood-board-title-edit" v-model="title"
            @blur="isEditing = false" @keyup.enter="isEditing = false" placeholder="My Mood Board" />
        <Toolbar @text-added="handleTextAdded" @image-selected="handleImageAdded"
            @color-selector-opened="handleColorSelectorOpened" @shape-added="handleShapeAdded"
            @prebuilt-item-added="handlePrebuiltItemAdded" @snap-to-grid-toggled="toggleSnapToGrid" />

        <div v-for="(text, index) in texts" :key="`text-${index}`" class="target">
            <Moveable class="moveable" v-bind:target="[`.mood-board-text-${index}`]" v-bind:draggable="true"
                v-bind:scalable="true" v-bind:rotatable="true" v-bind:bounds="boundsContainer" @drag="onDrag"
                @scale="onScale" @rotate="onRotate" />
            <input :value="text" :class="['mood-board-text', `mood-board-text-${index}`]" alt="Mood Board Text" />
        </div>

        <div v-for="(img, index) in images" :key="`image-${index}`" class="target image-target" :style="{
            position: 'absolute',
            left: `${img.x || 0}px`,
            top: `${img.y || 0}px`
        }">
            <Moveable class="moveable" v-bind:target="[`.mood-board-image-${index}`]" v-bind:draggable="true"
                v-bind:scalable="true" v-bind:rotatable="true" v-bind:bounds="boundsContainer"
                @drag="(e) => onImageDrag(e, index)" @scale="onScale" @rotate="onRotate" />
            <img :src="img.src" :class="['mood-board-image', `mood-board-image-${index}`]" alt="Mood Board Image" />
        </div>
    </div>
</template>

<script>
import { ref, nextTick } from 'vue'
import Toolbar from './Toolbar.vue';
import Moveable from 'vue3-moveable';

export default {
    components: {
        Toolbar,
        Moveable,
    },
    setup() {
        const isMobileDevice = ref(false);
        const isEditing = ref(false);
        const title = ref('My Mood Board');
        const images = ref([]);
        const texts = ref([]);
        const boundsContainer = ref(null);
        const snapToGrid = ref(false);
        const gridSize = ref(10);

        return {
            isMobileDevice,
            isEditing,
            title,
            images,
            texts,
            boundsContainer,
            snapToGrid,
            gridSize
        }
    },
    mounted() {
        this.isMobileDevice = this.checkIfMobile();
        // Set the bounds to the mood board container
        this.updateBoundsContainer();
    },
    methods: {
        updateBoundsContainer() {
            this.boundsContainer = {
                left: 0,
                top: 0,
                right: this.$refs.moodBoard.offsetWidth,
                bottom: this.$refs.moodBoard.offsetHeight
            };
        },
        checkIfMobile() {
            return /Mobi|Android/i.test(navigator.userAgent);
        },
        toggleSnapToGrid(enabled) {
            this.snapToGrid = enabled;
        },
        snapToGridPosition(position) {
            if (!this.snapToGrid) return position;

            // Round to the nearest grid point
            return Math.round(position / this.gridSize) * this.gridSize;
        },
        handleTextAdded() {
            // Logic to handle text added
            this.texts.push('Enter Text')
            console.log('Text added');
        },
        handleImageAdded(file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                // Store image with initial position
                this.images.push({
                    src: event.target.result,
                    x: 0,
                    y: 0
                });

                // Update bounds after adding a new image
                nextTick(() => {
                    this.updateBoundsContainer();
                });
            };
            reader.readAsDataURL(file);
        },
        handleColorSelectorOpened() {
            // Logic to handle color selector opened
            console.log('Color selector opened');
        },
        handleShapeAdded() {
            // Logic to handle shape added
            console.log('Shape added');
        },
        handlePrebuiltItemAdded() {
            // Logic to handle prebuilt item added
            console.log('Prebuilt item added');
        },
        onImageDrag({ target, left, top }, index) {
            // If snapToGrid is enabled, we snap to the grid
            if (this.snapToGrid) {
                // Snap the left and top positions to the nearest grid point
                const gridLeft = this.snapToGridPosition(left);
                const gridTop = this.snapToGridPosition(top);

                // Update the specific image's position in the images array
                this.images[index].x = gridLeft;
                this.images[index].y = gridTop;

                // Apply the snapped position to the target
                target.style.left = `${gridLeft}px`;
                target.style.top = `${gridTop}px`;
            } else {
                // If snapToGrid is false, apply the drag position directly
                target.style.left = `${left}px`;
                target.style.top = `${top}px`;

                // Update the image's position in the images array without snapping
                this.images[index].x = left;
                this.images[index].y = top;
            }
        },
        onDrag({ target, transform }) {
            target.style.transform = transform;
        },
        onScale({ target, drag }) {
            target.style.transform = drag.transform;
        },
        onRotate({ target, drag }) {
            target.style.transform = drag.transform;
        },
    }
}
</script>

<style lang="scss">
.mood-board {
    width: 90vw;
    max-width: 1200px;
    height: 80vh;
    max-height: 750px;
    border: 1px solid black;
    border-radius: 3px;
    margin: 2rem 0;
    background-color: white;
    background-image:
        linear-gradient(lightgrey 1px, transparent 1px),
        linear-gradient(90deg, lightgrey 1px, transparent 1px);
    background-size: 10px 10px; // Match the grid size
    background-position: 0 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.mood-board-image {
    max-width: 250px;
    max-height: 250px;
    object-fit: contain;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.image-target {
    position: absolute;
}

@media (max-width: 768px) {
    .mood-board {
        max-height: 500px;
    }
}
</style>