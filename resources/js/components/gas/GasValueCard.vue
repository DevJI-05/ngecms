<script setup lang="ts">
defineProps<{ icon: string; name: string; desc: string; accent: string }>();
</script>

<template>
    <div class="nilai-card" :style="{ borderTopColor: accent }">
        <div class="nilai-icon">
            <i class="ti" :class="icon" aria-hidden="true"></i>
        </div>
        <div class="nilai-name">{{ name }}</div>
        <div class="nilai-desc">{{ desc }}</div>
    </div>
</template>

<style scoped>
.nilai-card {
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: var(--border-radius-lg);
    padding: 16px;
    border-top: 3px solid transparent;
}
.nilai-icon {
    display: flex;
    align-items: center;
    font-size: 22px;
    margin-bottom: 8px;
}
.nilai-name {
    font-weight: 500;
    font-size: 13.5px;
    color: var(--color-text-primary);
    margin-bottom: 4px;
}
.nilai-desc {
    font-size: 12px;
    color: var(--color-text-secondary);
    line-height: 1.5;
}
</style>
