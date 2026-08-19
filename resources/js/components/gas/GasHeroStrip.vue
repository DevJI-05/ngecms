<script setup lang="ts">
withDefaults(
    defineProps<{
        crumb: string;
        title: string;
        subtitle?: string;
        subtitleWidth?: string;
        padBottom?: boolean;
    }>(),
    { subtitle: '', subtitleWidth: '420px', padBottom: true },
);
</script>

<template>
    <div class="hero-strip" :class="{ 'no-pad-bottom': !padBottom }">
        <div class="hero-flex">
            <div :class="{ 'hero-left-pad': !padBottom }">
                <div class="breadcrumb">
                    Beranda &rsaquo; <span>{{ crumb }}</span>
                </div>
                <div class="page-title">{{ title }}</div>
                <div
                    v-if="subtitle"
                    class="page-sub"
                    :style="{ maxWidth: subtitleWidth }"
                >
                    {{ subtitle }}
                </div>
            </div>
            <div v-if="$slots.stats" class="stat-row">
                <slot name="stats" />
            </div>
        </div>
    </div>
</template>

<style scoped>
.hero-strip {
    background: #0c447c;
    padding: 28px 28px 24px;
    border-bottom: 3px solid #ef9f27;
}
.hero-strip.no-pad-bottom {
    padding-bottom: 0;
}
.hero-left-pad {
    padding-bottom: 28px;
}
.breadcrumb {
    font-size: 11px;
    color: rgba(255, 255, 255, 0.5);
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 8px;
}
.breadcrumb span {
    color: rgba(255, 255, 255, 0.8);
}
.hero-flex {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
}
.page-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 36px;
    color: #fff;
    letter-spacing: -0.3px;
    line-height: 1;
}
.page-sub {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.65);
    margin-top: 6px;
    font-weight: 300;
    line-height: 1.6;
}
.stat-row {
    display: flex;
    gap: 0;
    flex-shrink: 0;
}

@media (max-width: 640px) {
    .hero-strip {
        padding: 22px 20px 18px;
    }
    .hero-flex {
        flex-direction: column;
        align-items: stretch;
        gap: 14px;
    }
    .page-title {
        font-size: 28px;
    }
    .stat-row {
        flex-wrap: wrap;
    }
    .stat-row :deep(.stat-box) {
        flex: 1;
        min-width: 100px;
    }
}
</style>
