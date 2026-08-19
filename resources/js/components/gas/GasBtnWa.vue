<script setup lang="ts">
defineEmits<{ click: [] }>();
</script>

<template>
    <button class="btn-wa" @click="$emit('click')">
        <i class="ti ti-brand-whatsapp" aria-hidden="true"></i>
        <slot />
    </button>
</template>

<style scoped>
.btn-wa {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 9px 16px;
    border-radius: 6px;
    background: #eaf3de;
    color: #27500a;
    font-family: 'Barlow', sans-serif;
    font-size: 13px;
    font-weight: 500;
    border: 0.5px solid #97c459;
    cursor: pointer;
}
</style>
