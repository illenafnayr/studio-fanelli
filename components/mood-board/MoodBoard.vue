<template>
    <div class="mood-board">
        <h2 v-if="!isMobileDevice && !isEditing" class="mood-board-title" @dblclick="isEditing = true">{{ title }}</h2>
        <input v-if="isMobileDevice || isEditing" class="mood-board-title-edit" v-model="title"
            @blur="isEditing = false" @keyup.enter="isEditing = false" placeholder="Mood Board Title" />
        <Toolbar @text-added="handleTextAdded" @image-selected="handleImageAdded"
            @color-selector-opened="handleColorSelectorOpened" @shape-added="handleShapeAdded"
            @prebuilt-item-added="handlePrebuiltItemAdded" />

        <div v-for="(img, index) in images" :key="index" class="target">
            <Moveable
                class="moveable"
                v-bind:target="['.mood-board-image']"
                v-bind:draggable="true"
                v-bind:scalable="true"
                v-bind:rotatable="true"
                @drag="onDrag"
                @scale="onScale"
                @rotate="onRotate"
            />
            <img :src="img" alt="Mood Board Image" class="mood-board-image" />
        </div>

    </div>
</template>
<script>
import Toolbar from './Toolbar.vue';
import Moveable from 'vue3-moveable';

export default {
    components: {
        Toolbar,
        Moveable,
    },
    data() {
        return {
            isMobileDevice: false,
            isEditing: false,
            title: 'Mood Board Title',
            images: [],
            imageWidth: 100, // Set default width to 100
            imageHeight: 250, // Default height
            imageX: 0, // Default x position
            imageY: 0, // Default y position
        };
    },
    mounted() {
        this.isMobileDevice = this.checkIfMobile();
        console.log("this.isMobileDevice", this.isMobileDevice)
    },
    methods: {
        checkIfMobile() {
            return /Mobi|Android/i.test(navigator.userAgent);
        },
        handleTextAdded() {
            // Logic to handle text added
            console.log('Text added');
        },
        handleImageAdded(file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                this.images.push(event.target.result);
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
    background-image: linear-gradient(lightgrey 1px, transparent 1px),
        linear-gradient(90deg, lightgrey 1px, transparent 1px);
    background-size: 10px 10px;
    background-position: 0 0;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.mood-board-title {
    background-color: rgba(255, 255, 255, 0.718);
    padding: 0.5rem;
    border-radius: 5px;
}

.mood-board-title-edit {
    font-size: 1.5rem;
    font-weight: bold;
    border: 1px solid #ccc;
    background-color: transparent;
    color: inherit;
    padding: 0.5rem;
    width: fit-content;
    min-width: 8rem;
    margin-top: 1rem;
    border-radius: 3px;
    text-align: center;

}

.mood-board-image {
    max-width: 100%;
    height: 250px;
    width: auto;
    border: 1px solid #ccc;
    border-radius: 5px;
    display: block; // Ensure the image is treated as a block element
}

@media (max-width: 768px) {
    .mood-board {
        max-height: 500px;
    }
}
</style>