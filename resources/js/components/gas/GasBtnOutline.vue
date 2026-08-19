<script setup lang="ts">
withDefaults(defineProps<{ icon?: string }>(), { icon: '' });
defineEmits<{ click: [] }>();
</script>

<template>
    <button class="btn-outline" @click="$emit('click')">
        <i v-if="icon" class="ti" :class="icon" aria-hidden="true"></i>
        <slot />
    </button>
</template>

<style scoped>
.btn-outline {
    background: transparent;
    color: #fff;
    font-family: 'Barlow', sans-serif;
    font-weight: 500;
    font-size: 13px;
    padding: 10px 20px;
    border-radius: 6px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    cursor: pointer;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 6px;
}
</style>
