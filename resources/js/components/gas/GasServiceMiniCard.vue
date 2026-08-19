<script setup lang="ts">
defineProps<{
    icon: string;
    iconBg: string;
    iconColor: string;
    title: string;
    desc: string;
}>();
</script>

<template>
    <div class="service-card">
        <div
            class="service-icon"
            :style="{ background: iconBg, color: iconColor }"
        >
            <i class="ti" :class="icon" aria-hidden="true"></i>
        </div>
        <div class="service-title">{{ title }}</div>
        <p class="service-desc">{{ desc }}</p>
    </div>
</template>

<style scoped>
.service-card {
    background: var(--color-background-secondary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: 10px;
    padding: 20px;
    border-top: 3px solid transparent;
    cursor: pointer;
    transition: border-top-color 0.2s;
}
.service-card:hover {
    border-top-color: #ef9f27;
}
.service-icon {
    width: 40px;
    height: 40px;
    background: #e6f1fb;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
    color: #185fa5;
    font-size: 20px;
}
.service-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 600;
    font-size: 16px;
    color: var(--color-text-primary);
    margin-bottom: 6px;
    letter-spacing: 0.2px;
}
.service-desc {
    font-size: 12.5px;
    color: var(--color-text-secondary);
    line-height: 1.6;
}
</style>
