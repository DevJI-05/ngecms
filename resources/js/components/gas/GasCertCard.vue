<script setup lang="ts">
defineProps<{
    icon: string;
    iconBg: string;
    iconColor: string;
    name: string;
    issuer: string;
    valid: string;
}>();
</script>

<template>
    <div class="cert-card">
        <div
            class="cert-icon"
            :style="{ background: iconBg, color: iconColor }"
        >
            <i class="ti" :class="icon" aria-hidden="true"></i>
        </div>
        <div>
            <div class="cert-name">{{ name }}</div>
            <div class="cert-issuer">{{ issuer }}</div>
            <span class="cert-valid"
                ><i
                    class="ti ti-circle-check"
                    style="font-size: 12px; vertical-align: -1px"
                    aria-hidden="true"
                ></i>
                {{ valid }}</span
            >
        </div>
    </div>
</template>

<style scoped>
.cert-card {
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: var(--border-radius-lg);
    padding: 18px;
    display: flex;
    gap: 14px;
    align-items: flex-start;
}
.cert-icon {
    width: 44px;
    height: 44px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}
.cert-name {
    font-weight: 600;
    font-size: 14px;
    color: var(--color-text-primary);
    margin-bottom: 3px;
}
.cert-issuer {
    font-size: 12px;
    color: var(--color-text-secondary);
    margin-bottom: 5px;
}
.cert-valid {
    font-size: 11px;
    font-weight: 500;
    color: #3b6d11;
    background: #eaf3de;
    padding: 2px 8px;
    border-radius: 3px;
    display: inline-block;
}
</style>
