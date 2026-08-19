<script setup lang="ts">
defineProps<{ text: string; sub: string }>();
</script>

<template>
    <div class="cta-strip">
        <div>
            <div class="cta-text">{{ text }}</div>
            <div class="cta-sub">{{ sub }}</div>
        </div>
        <div class="cta-btns">
            <slot />
        </div>
    </div>
</template>

<style scoped>
.cta-strip {
    background: #042c53;
    padding: 20px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}
.cta-text {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 21px;
    font-weight: 700;
    color: #fff;
}
.cta-sub {
    font-size: 12.5px;
    color: rgba(255, 255, 255, 0.6);
    margin-top: 3px;
    font-weight: 300;
}
.cta-btns {
    display: flex;
    gap: 10px;
    flex-shrink: 0;
}

@media (max-width: 640px) {
    .cta-strip {
        flex-direction: column;
        align-items: stretch;
        text-align: center;
        padding: 20px;
    }
    .cta-btns {
        flex-direction: column;
    }
    .cta-btns :deep(button) {
        justify-content: center;
    }
}
</style>
