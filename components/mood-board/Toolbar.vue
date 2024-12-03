<template>
    <div class="toolbar">
        <div class="icon-container">
            <img id="text-icon" src="../../assets/text-icon.png" @click="addText" />
            <img id="add-image-icon" src="../../assets/add-image-icon.png" @click="addImage" />
            <img id="color-select-icon" src="../../assets/color-select-icon.png" @click="openColorSelector" />
            <img id="shape-icon" src="../../assets/shape-icon.png" @click="addShape" />
            <img id="prebuilt-icon" src="../../assets/prebuilt-icon.png" @click="addPrebuiltItem" />
        </div>
    </div>
</template>

<script>
export default {
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
    height: 12rem;
    width: 2.67rem;
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
            width: 1.5rem;
            height: 1.5rem;
            padding: 0.2rem;
            transition: all 0.3s ease-in-out;
            cursor: pointer;

            // Subtle shadow for depth
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
            scale: 1.1;
        }

        #add-image-icon {
            border: none;
            scale: 1.5;
        }

        #color-select-icon {
            border: none;
            scale: 1.5;
        }

        // Specific icon hover effects
        #text-icon:hover {
            background-color: rgba(44, 62, 80, 0.1); // Deep blue-grey tint
            border: 1px solid rgb(51, 51, 51);
        }

        // #add-image-icon:hover {
        //     // background-color: rgba(52, 152, 219, 0.1); // Vibrant blue tint
        // }

        // #color-select-icon:hover {
        //     background-color: rgba(155, 89, 182, 0.1); // Rich purple tint
        // }
    }
}

// Responsive adjustments
@media (max-width: 768px) {
    .toolbar .icon-container img:hover {
        transform: scale(1.1);
    }
}
</style>