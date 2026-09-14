<script setup lang="ts">
withDefaults(
    defineProps<{
        badge: string;
        description: string;
        descriptionWidth?: string;
    }>(),
    { descriptionWidth: '420px' },
);
</script>

<template>
    <div class="hero">
        <div class="hero-pattern"></div>

        <slot name="navbar" />

        <div class="hero-body">
            <div class="hero-left">
                <div class="hero-badge">{{ badge }}</div>
                <h1 class="hero-title"><slot name="title" /></h1>
                <p class="hero-desc" :style="{ maxWidth: descriptionWidth }">
                    {{ description }}
                </p>
                <div v-if="$slots.buttons" class="hero-btns">
                    <slot name="buttons" />
                </div>
            </div>

            <div v-if="$slots.stats" class="hero-right">
                <slot name="stats" />
            </div>
        </div>
    </div>
</template>

<style scoped>
.hero {
    background: linear-gradient(135deg, #042c53 0%, #0c447c 60%, #185fa5 100%);
    padding: 0;
    position: relative;
    min-height: 380px;
    display: flex;
    flex-direction: column;
}

.hero-pattern {
    position: absolute;
    inset: 0;
    background-image:
        repeating-linear-gradient(
            0deg,
            transparent,
            transparent 40px,
            rgba(255, 255, 255, 0.03) 40px,
            rgba(255, 255, 255, 0.03) 41px
        ),
        repeating-linear-gradient(
            90deg,
            transparent,
            transparent 40px,
            rgba(255, 255, 255, 0.03) 40px,
            rgba(255, 255, 255, 0.03) 41px
        );
}

.hero-body {
    padding: 40px 32px 48px;
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 32px;
}

.hero-left {
    flex: 1;
}

.hero-badge {
    display: inline-block;
    background: rgba(239, 159, 39, 0.2);
    color: #ef9f27;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    padding: 5px 12px;
    border-radius: 3px;
    border: 1px solid rgba(239, 159, 39, 0.4);
    margin-bottom: 16px;
}

.hero-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 48px;
    color: #fff;
    line-height: 1.05;
    margin-bottom: 14px;
    letter-spacing: -0.5px;
}

.hero-title :deep(span) {
    color: #ef9f27;
}

.hero-desc {
    font-size: 15px;
    color: rgba(255, 255, 255, 0.7);
    line-height: 1.65;
    margin-bottom: 24px;
    font-weight: 300;
}

.hero-btns {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
}

.hero-right {
    display: flex;
    flex-direction: column;
    gap: 10px;
    min-width: 180px;
}

@media (max-width: 900px) {
    .hero-body {
        flex-direction: column;
        align-items: stretch;
        padding: 28px 20px 32px;
    }
    .hero-right {
        flex-direction: row;
        min-width: 0;
        width: 100%;
        flex-wrap: wrap;
    }
    .hero-right :deep(.stat-box) {
        flex: 1;
        min-width: 100px;
    }
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 34px;
    }
    .hero-desc {
        max-width: 100% !important;
    }
}

@media (max-width: 560px) {
    .hero-right {
        flex-direction: column;
    }
    .hero-btns {
        flex-direction: column;
        align-items: stretch;
    }
    .hero-btns :deep(button) {
        justify-content: center;
    }
}
</style>
