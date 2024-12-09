<template>
    <div class="toolbar">
        <div class="icon-container">
            <img id="text-icon" src="../../assets/text-icon.png" @click="addText" />
            <img id="add-image-icon" src="../../assets/add-image-icon.png" @click="addImage" />
            <img id="color-select-icon" src="../../assets/color-select-icon.png" @click="openColorSelector" />
            <img id="shape-icon" src="../../assets/shape-icon.png" @click="addShape" />
            <img id="prebuilt-icon" src="../../assets/prebuilt-icon.png" @click="addPrebuiltItem" />
            
            <!-- New Snap to Grid toggle -->
            <div class="snap-to-grid-container">
                <input 
                    type="checkbox" 
                    id="snap-to-grid" 
                    v-model="isSnapToGridEnabled"
                    @change="toggleSnapToGrid"
                />
                <label for="snap-to-grid">Snap to Grid</label>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isSnapToGridEnabled: false
        };
    },
    methods: {
        addText() {
            // Logic to add text
            this.$emit('text-added'); // Emit event
        },
        addImage() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = (event) => {
                const file = event.target.files[0];
                if (file) {
                    this.$emit('image-selected', file); // Emit the selected file
                }
            };
            input.click(); // Trigger the file selector
        },
        openColorSelector() {
            // Logic to open color selector modal
            this.$emit('color-selector-opened'); // Emit event
        },
        addShape() {
            // Logic to add shape
            this.$emit('shape-added'); // Emit event
        },
        addPrebuiltItem() {
            // Logic to add prebuilt item
            this.$emit('prebuilt-item-added'); // Emit event
        },
        toggleSnapToGrid() {
            // Emit an event with the current state of snap to grid
            this.$emit('snap-to-grid-toggled', this.isSnapToGridEnabled);
        }
    }
}
</script>

<style scoped lang="scss">
.toolbar {
    position: relative;
    z-index: 999;
    display: flex;
    flex-direction: column;
    border: 1px solid black;
    border-radius: 3px;
    height: 50%;
    min-height: 12rem;
    width: 3.5rem;
    align-self: flex-start;
    margin: 1.8rem;
    background-color: white;

    .icon-container {
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-evenly;

        img {
            border: 1px solid black;
            border-radius: 3px;
            width: 2rem;
            height: 2rem;
            padding: 0.3rem;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            filter: brightness(0.9) drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));

            &:hover {
                transform: scale(1.1);
                filter: brightness(1.1) drop-shadow(0 4px 6px rgba(0, 0, 0, 0.2));
            }

            &:active {
                transform: scale(0.95);
                transition: transform 0.1s ease;
            }
        }

        #text-icon {
            scale: 1.2;
        }

        #add-image-icon {
            border: none;
            scale: 1.6;
        }

        #color-select-icon {
            border: none;
            scale: 1.6;
        }

        #text-icon:hover {
            background-color: rgba(44, 62, 80, 0.1);
            border: 1px solid rgb(51, 51, 51);
        }

        // Snap to Grid container styling
        .snap-to-grid-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 0.5rem;
            
            input[type="checkbox"] {
                margin-bottom: 0.25rem;
            }

            label {
                font-size: 0.7rem;
                text-align: center;
                white-space: nowrap;
            }
        }
    }
}

// Responsive adjustments
@media (max-width: 768px) {
    .toolbar .icon-container img:hover {
        transform: scale(1.1);
    }
}
</style>