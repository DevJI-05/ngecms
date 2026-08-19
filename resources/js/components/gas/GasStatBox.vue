<script setup lang="ts">
withDefaults(
    defineProps<{ num: string; label: string; size?: 'sm' | 'lg' }>(),
    {
        size: 'sm',
    },
);
</script>

<template>
    <div class="stat-box" :class="size">
        <span class="stat-num">{{ num }}</span>
        <span class="stat-lbl">{{ label }}</span>
    </div>
</template>

<style scoped>
.stat-box {
    padding: 12px 18px;
    background: rgba(255, 255, 255, 0.07);
    border-left: 0.5px solid rgba(255, 255, 255, 0.12);
    text-align: center;
}
.stat-num {
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 22px;
    color: #ef9f27;
    display: block;
}
.stat-lbl {
    font-size: 10px;
    color: rgba(255, 255, 255, 0.5);
    letter-spacing: 1px;
    text-transform: uppercase;
}
.stat-box.lg {
    padding: 14px 22px;
}
.stat-box.lg .stat-num {
    font-size: 24px;
}
</style>
