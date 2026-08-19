<script setup lang="ts">
defineProps<{
    tag: string;
    name: string;
    info: string;
    cng?: boolean;
}>();
</script>

<template>
    <div class="project-card">
        <div class="project-bar" :class="{ cng }"></div>
        <div class="project-content">
            <div class="project-tag" :class="{ cng }">{{ tag }}</div>
            <div class="project-name">{{ name }}</div>
            <div class="project-info">{{ info }}</div>
        </div>
    </div>
</template>

<style scoped>
.project-card {
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: 10px;
    overflow: hidden;
    display: flex;
}
.project-bar {
    width: 5px;
    background: #185fa5;
    flex-shrink: 0;
}
.project-bar.cng {
    background: #ef9f27;
}
.project-content {
    padding: 14px 16px;
}
.project-tag {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #185fa5;
    margin-bottom: 5px;
}
.project-tag.cng {
    color: #ba7517;
}
.project-name {
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 600;
    font-size: 15px;
    color: var(--color-text-primary);
    margin-bottom: 4px;
}
.project-info {
    font-size: 12px;
    color: var(--color-text-secondary);
}
</style>
