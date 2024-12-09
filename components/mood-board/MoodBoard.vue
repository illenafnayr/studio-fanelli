<template>
    <div class="mood-board" ref="moodBoard">
        <h2 v-if="!isMobileDevice && !isTitleEditing" class="mood-board-title" @dblclick="isTitleEditing = true">
            {{ title }}
        </h2>
        <input v-if="isMobileDevice || isTitleEditing" class="mood-board-title-edit" v-model="title"
            @blur="isTitleEditing = false" @keyup.enter="isTitleEditing = false" placeholder="My Mood Board" />
        <Toolbar @text-added="handleTextAdded" @image-selected="handleImageAdded"
            @color-selector-opened="handleColorSelectorOpened" @shape-added="handleShapeAdded"
            @prebuilt-item-added="handlePrebuiltItemAdded" @snap-to-grid-toggled="toggleSnapToGrid" />

        <div v-for="(text, index) in texts" :key="`text-${index}`" class="target text-target" :style="{
            position: 'absolute',
            left: `${text.x || 0}px`,
            top: `${text.y || 0}px`
        }">
            <Moveable v-if="!text.isEditing" class="moveable" :target="[`.mood-board-text-${index}`]" :draggable="true"
                :scalable="true" :rotatable="true" :bounds="boundsContainer" @drag="(e) => handleDrag(e, 'text', index)"
                @scale="onScale" @rotate="onRotate" />
            <input v-model="text.text"
                :class="['mood-board-text', `mood-board-text-${index}`, { 'is-editing': text.isEditing }]"
                alt="Mood Board Text" @dblclick="startTextEditing(index)" @blur="stopTextEditing(index)"
                @keyup.enter="stopTextEditing(index)" :readonly="!text.isEditing" />
        </div>

        <div v-for="(img, index) in images" :key="`image-${index}`" class="target image-target" :style="{
            position: 'absolute',
            left: `${img.x || 0}px`,
            top: `${img.y || 0}px`
        }">
            <Moveable class="moveable" :target="[`.mood-board-image-${index}`]" :draggable="true" :scalable="true"
                :rotatable="true" :bounds="boundsContainer" @drag="(e) => handleDrag(e, 'image', index)"
                @scale="onScale" @rotate="onRotate" />
            <img :src="img.src" :class="['mood-board-image', `mood-board-image-${index}`]" alt="Mood Board Image" />
        </div>
    </div>
</template>

<script>
import { ref, nextTick } from 'vue';
import Toolbar from './Toolbar.vue';
import Moveable from 'vue3-moveable';

export default {
    components: {
        Toolbar,
        Moveable,
    },
    setup() {
        const isMobileDevice = ref(false);
        const isTitleEditing = ref(false);
        const title = ref('My Mood Board');
        const images = ref([]);
        const texts = ref([]);
        const boundsContainer = ref(null);
        const snapToGrid = ref(false);
        const gridSize = ref(10);

        return {
            isMobileDevice,
            isTitleEditing,
            title,
            images,
            texts,
            boundsContainer,
            snapToGrid,
            gridSize,
        };
    },
    mounted() {
        this.isMobileDevice = this.checkIfMobile();
        this.updateBoundsContainer();
        window.addEventListener('resize', this.updateBoundsContainer);
    },
    unmounted() {
        window.removeEventListener('resize', this.updateBoundsContainer);
    },
    methods: {
        updateBoundsContainer() {
            const moodBoard = this.$refs.moodBoard;
            if (moodBoard) {
                this.boundsContainer = {
                    left: 0,
                    top: 0,
                    right: moodBoard.offsetWidth,
                    bottom: moodBoard.offsetHeight,
                };
            }
        },
        checkIfMobile() {
            return /Mobi|Android/i.test(navigator.userAgent);
        },
        toggleSnapToGrid(enabled) {
            this.snapToGrid = enabled;
        },
        snapToGridPosition(position) {
            if (!this.snapToGrid) return position;
            return Math.round(position / this.gridSize) * this.gridSize;
        },
        handleDrag({ target, left, top }, itemType, index) {
            const targetArray = itemType === 'text' ? this.texts : this.images;
            if (!targetArray[index]) {
                console.error(`${itemType} at index ${index} does not exist.`);
                return;
            }
            if (itemType === 'text' && targetArray[index].isEditing) return;

            const snappedLeft = this.snapToGrid ? this.snapToGridPosition(left) : left;
            const snappedTop = this.snapToGrid ? this.snapToGridPosition(top) : top;

            targetArray[index].x = snappedLeft;
            targetArray[index].y = snappedTop;

            target.style.left = `${snappedLeft}px`;
            target.style.top = `${snappedTop}px`;
        },
        startTextEditing(index) {
            this.texts[index].isEditing = true;
            nextTick(() => {
                const input = document.querySelector(`.mood-board-text-${index}`);
                if (input) input.focus();
            });
        },
        stopTextEditing(index) {
            this.texts[index].isEditing = false;
        },
        handleTextAdded() {
            this.texts.push({
                text: 'Enter Text',
                x: 0,
                y: 0,
                isEditing: false,
            });
        },
        handleImageAdded(file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                this.images.push({
                    src: event.target.result,
                    x: 0,
                    y: 0,
                });
                nextTick(() => {
                    this.updateBoundsContainer();
                });
            };
            reader.readAsDataURL(file);
        },
        handleColorSelectorOpened() {
            console.log('Color selector opened');
        },
        handleShapeAdded() {
            console.log('Shape added');
        },
        handlePrebuiltItemAdded() {
            console.log('Prebuilt item added');
        },
        onScale({ target, drag }) {
            target.style.transform = drag.transform;
        },
        onRotate({ target, drag }) {
            target.style.transform = drag.transform;
        },
    },
};
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
    background-size: 10px 10px;
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

.mood-board-text {
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: white;
    font-size: 14px;
}

.mood-board-text.is-editing {
    outline: 2px solid blue;
    background-color: #f0f8ff;
}

.image-target,
.text-target {
    position: absolute;
}
</style>