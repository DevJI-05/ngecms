<script setup lang="ts">
withDefaults(
    defineProps<{ icon?: string; size?: 'sm' | 'md'; textColor?: string }>(),
    {
        icon: '',
        size: 'md',
        textColor: '#412402',
    },
);
defineEmits<{ click: [] }>();
</script>

<template>
    <button
        class="btn-primary"
        :class="size"
        :style="{ color: textColor }"
        @click="$emit('click')"
    >
        <i v-if="icon" class="ti" :class="icon" aria-hidden="true"></i>
        <slot />
    </button>
</template>

<style scoped>
.btn-primary {
    background: #ef9f27;
    font-family: 'Barlow', sans-serif;
    font-weight: 600;
    font-size: 13px;
    padding: 10px 20px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.btn-primary.sm {
    padding: 9px 16px;
}
</style>
