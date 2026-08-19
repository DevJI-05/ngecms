<script setup lang="ts">
defineProps<{
    year: string;
    dotColor: string;
    badge: string;
    badgeBg: string;
    badgeColor: string;
    name: string;
    desc: string;
}>();
</script>

<template>
    <div class="tl-item">
        <div
            class="tl-dot"
            :style="{ background: dotColor, color: dotColor }"
        ></div>
        <div class="tl-year" :style="{ color: dotColor }">{{ year }}</div>
        <div class="tl-card">
            <span
                class="tl-badge"
                :style="{ background: badgeBg, color: badgeColor }"
                >{{ badge }}</span
            >
            <div class="tl-name">{{ name }}</div>
            <div class="tl-desc">{{ desc }}</div>
        </div>
    </div>
</template>

<style scoped>
.tl-item {
    position: relative;
    margin-bottom: 22px;
}
.tl-dot {
    position: absolute;
    left: -26px;
    top: 4px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px currentColor;
}
.tl-year {
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 13px;
    letter-spacing: 0.5px;
    margin-bottom: 3px;
}
.tl-card {
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: var(--border-radius-lg);
    padding: 13px 16px;
}
.tl-name {
    font-weight: 500;
    font-size: 13.5px;
    color: var(--color-text-primary);
    margin-bottom: 3px;
}
.tl-desc {
    font-size: 12px;
    color: var(--color-text-secondary);
    line-height: 1.5;
}
.tl-badge {
    display: inline-block;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    padding: 2px 8px;
    border-radius: 3px;
    margin-bottom: 5px;
}
</style>
