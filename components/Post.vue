<template>
    <NuxtLink :to='post[0].uri'>
        <div class="flex
        items-center
        bg-gradient-to-r
        from-cyan-500
        to-blue-500
        p-8
        rounded-lg
        text-white
        transition-all
        hover:-translate-y-1
        hover:scale-105">
            <div>
                <h2 class="font-semibold text-2xl">{{ post[0].title }}</h2>
                <p>{{ new Date(post[0].date).toLocaleDateString() }}</p>
                <div v-html="post[0].excerpt"></div>
            </div>
        </div>
    </NuxtLink>
</template>
<script setup lang="ts">
const props = defineProps<{
    post: Record<'title' | 'date' | 'excerpt' | 'uri', string>[]
}>();

console.log('Post prop:', props.post);

</script>