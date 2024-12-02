<template>
    <div class="toolbar">
        <div class="icon-container">
            <img src="" @click="addText" />
            <img src="../../assets/text-icon.png" @click="addImage" />
            <img src="" @click="openColorSelector" />
            <img src="" @click="addShape" />
            <img src="" @click="addPrebuiltItem" />
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

<style scoped>
.toolbar {
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
        }
    }
}

.icon-container {
    display: flex;
    flex-direction: column;
}
</style>
