<template>
    <div class="mood-board">
    <h2 v-if="!isMobileDevice && !isEditing" class="mood-board-title" @dblclick="isEditing = true">{{ title }}</h2>
    <input v-if="isMobileDevice || isEditing" class="mood-board-title-edit" v-model="title" @blur="isEditing = false" @keyup.enter="isEditing = false" placeholder="Mood Board Title" />
        
    </div>
</template>
<script>
export default {
    data() {
        return {
            isMobileDevice: false,
            isEditing: false,
            title: 'Mood Board Title',
        };
    },
    mounted() {
        this.isMobileDevice = this.checkIfMobile();
        console.log("this.isMobileDevice", this.isMobileDevice)
    },
    methods: {
        checkIfMobile() {
            return /Mobi|Android/i.test(navigator.userAgent);
        }
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
    display: flex;
    flex-direction: column;
    align-items: center;
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

@media (max-width: 768px) {
    .mood-board {
        max-height: 500px;
    }
}
</style>