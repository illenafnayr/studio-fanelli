<template>
    <div class="mood-board" ref="moodBoard">
        <canvas ref="canvasRef" @mousedown="startDrawing" @mouseup="stopDrawing" @mousemove="draw"
            :style="{ position: 'absolute', left: 0, top: 0, width: '100%', height: '100%', zIndex: 1 }"></canvas>
        <div class="mood-board-title--container">
            <h2 v-if="!isMobileDevice && !isTitleEditing" class="mood-board-title" @dblclick="isTitleEditing = true">
                {{ title }}
            </h2>
            <img v-if="isMobileDevice || !isTitleEditing" src="../../assets/edit-icon.png" alt="Edit Icon"
                class="edit-icon" />
        </div>
        <div class="title-container">
            <input v-if="isMobileDevice || isTitleEditing" class="mood-board-title-edit" v-model="title"
                @blur="isTitleEditing = false" @keyup.enter="isTitleEditing = false" placeholder="My Mood Board"
                :style="{ fontSize: 'inherit', fontFamily: 'inherit' }" />
        </div>
        <Toolbar @text-added="handleTextAdded" @image-selected="handleImageAdded"
            @color-selector-opened="handleColorSelectorOpened" @shape-added="handleShapeAdded"
            @draw-tool-selected="handleDrawToolSelected" @snap-to-grid-toggled="toggleSnapToGrid" />

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
import { ref, nextTick, onMounted, onUnmounted } from 'vue';
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
        const isDrawing = ref(false);
        const color = ref('#000000'); // Default color
        const canvasRef = ref(null);
        const ctx = ref(null);

        const initializeCanvas = () => {
            if (canvasRef.value) {
                // Set canvas to full size of parent container with device pixel ratio
                const container = canvasRef.value.parentElement;
                const dpr = window.devicePixelRatio || 1;

                // Set display size
                canvasRef.value.style.width = `${container.clientWidth}px`;
                canvasRef.value.style.height = `${container.clientHeight}px`;

                // Scale canvas for high DPI screens
                canvasRef.value.width = container.clientWidth * dpr;
                canvasRef.value.height = container.clientHeight * dpr;

                // Get 2D rendering context
                const context = canvasRef.value.getContext('2d');
                context.scale(dpr, dpr);

                ctx.value = context;
                ctx.value.lineCap = 'round';
                ctx.value.lineWidth = 5;
                ctx.value.strokeStyle = color.value;
            }
        };

        const startDrawing = (event) => {
            if (!ctx.value) return;

            isDrawing.value = true;
            const rect = canvasRef.value.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;

            ctx.value.beginPath();
            ctx.value.moveTo(x, y);
        };

        const draw = (event) => {
            if (!isDrawing.value || !ctx.value) return;

            const rect = canvasRef.value.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;

            ctx.value.lineTo(x, y);
            ctx.value.stroke();
        };

        const stopDrawing = () => {
            if (!ctx.value) return;

            isDrawing.value = false;
            ctx.value.closePath();
        };

        const handleDrawToolSelected = () => {
            const selectedColor = prompt("Select a color (hex code):", color.value);
            if (selectedColor) {
                color.value = selectedColor;
                if (ctx.value) {
                    ctx.value.strokeStyle = color.value;
                }
            }

            // Ensure canvas is initialized and clear previous drawings
            nextTick(() => {
                initializeCanvas();
                if (ctx.value) {
                    ctx.value.clearRect(0, 0, canvasRef.value.width, canvasRef.value.height);
                }
            });
        };

        onMounted(() => {
            isMobileDevice.value = /Mobi|Android/i.test(navigator.userAgent);

            // Initialize canvas with a slight delay to ensure DOM is ready
            nextTick(() => {
                initializeCanvas();
                updateBoundsContainer();
                window.addEventListener('resize', () => {
                    initializeCanvas();
                    updateBoundsContainer();
                });
            });
        });

        onUnmounted(() => {
            window.removeEventListener('resize', () => {
                initializeCanvas();
                updateBoundsContainer();
            });
        });

        const updateBoundsContainer = () => {
            const moodBoard = document.querySelector('.mood-board');
            if (moodBoard) {
                boundsContainer.value = {
                    left: 0,
                    top: 0,
                    right: moodBoard.offsetWidth,
                    bottom: moodBoard.offsetHeight,
                };
            }
        };

        return {
            isMobileDevice,
            isTitleEditing,
            title,
            images,
            texts,
            boundsContainer,
            snapToGrid,
            gridSize,
            isDrawing,
            color,
            canvasRef,
            startDrawing,
            stopDrawing,
            draw,
            handleDrawToolSelected,
            ctx,
        };
    },
    methods: {
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

    .mood-board-title--container {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        gap: 1rem;

        img {
            margin-bottom: 5px;
        }
    }

    .mood-board-title-edit {
        margin: 1rem;
        padding: 0.5rem;
    }

    .title-container {
        display: flex;
        align-items: center;
    }

    .image-target,
    .text-target {
        position: absolute;
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

        &.is-editing {
            outline: 2px solid rgb(51, 51, 115);
            background-color: #f0f8ff;
        }
    }

    .edit-icon {
        width: 20px;
        height: 20px;
        margin-left: 8px;
    }
}
</style>