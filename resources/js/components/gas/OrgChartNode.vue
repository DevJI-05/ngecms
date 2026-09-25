<script setup lang="ts">
import { computed } from 'vue';
import { rowWidth, type OrgTreeNode } from '@/lib/orgTree';

const props = defineProps<{ node: OrgTreeNode; depth: number }>();

const tier = computed(() => Math.min(props.depth, 3));
const childRowWidth = computed(() => rowWidth(props.node.children, props.depth + 1));
</script>

<template>
    <div class="org-node">
        <div v-if="depth > 0" class="org-drop" :class="{ 'org-drop-sm': depth > 1 }"></div>
        <div
            class="org-card"
            :class="`tier-${tier}`"
            :style="{ borderTopColor: node.member.avatar_color }"
        >
            <div
                class="org-avatar"
                :class="`tier-${tier}`"
                :style="{
                    background: node.member.avatar_bg,
                    color: node.member.avatar_color,
                }"
            >
                {{ node.member.initials }}
            </div>
            <div class="org-name" :class="`tier-${tier}`">{{ node.member.name }}</div>
            <div class="org-role">{{ node.member.role }}</div>
        </div>

        <template v-if="node.children.length">
            <div class="org-stem" :class="{ 'org-stem-sm': depth > 0 }"></div>
            <div
                class="org-row"
                :class="{ 'has-bus': node.children.length > 1 }"
                :style="{ '--tier-w': childRowWidth + 'px' }"
            >
                <OrgChartNode
                    v-for="child in node.children"
                    :key="child.member.id"
                    :node="child"
                    :depth="depth + 1"
                />
            </div>
        </template>
    </div>
</template>

<style scoped>
.org-node {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: var(--tier-w, 200px);
}

.org-card {
    position: relative;
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: var(--border-radius-lg);
    padding: 14px 12px;
    text-align: center;
    box-shadow: 0 1px 2px rgba(16, 35, 58, 0.06);
    transition:
        transform 0.15s ease,
        box-shadow 0.15s ease;
}
.org-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(16, 35, 58, 0.12);
}

.org-card.tier-0 {
    width: 200px;
    border-top: 3px solid #185fa5;
    padding: 18px 14px;
}
.org-card.tier-1 {
    width: 172px;
    border-top: 3px solid #ef9f27;
}
.org-card.tier-2 {
    width: 150px;
    border-top: 3px solid #3b6d11;
    padding: 12px 10px;
}
.org-card.tier-3 {
    width: 140px;
    border-top: 3px solid #64748b;
    padding: 12px 10px;
}

.org-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 15px;
    margin: 0 auto 8px;
    box-shadow: 0 0 0 3px var(--color-background-primary);
}
.org-avatar.tier-1 {
    width: 40px;
    height: 40px;
    font-size: 14px;
}
.org-avatar.tier-2,
.org-avatar.tier-3 {
    width: 30px;
    height: 30px;
    font-size: 11px;
}

.org-name {
    font-weight: 600;
    font-size: 13px;
    color: var(--color-text-primary);
    line-height: 1.25;
}
.org-name.tier-2,
.org-name.tier-3 {
    font-size: 11.5px;
}
.org-role {
    font-size: 10.5px;
    color: var(--color-text-tertiary);
    margin-top: 3px;
    line-height: 1.3;
}

/* connector lines */
.org-stem {
    width: 2px;
    height: 24px;
    background: var(--color-border-secondary);
    margin: 0 auto;
    position: relative;
}
.org-stem::after {
    content: '';
    position: absolute;
    left: 50%;
    bottom: -1px;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--color-border-secondary);
    transform: translate(-50%, 50%);
}
.org-stem-sm {
    height: 20px;
}

.org-row {
    position: relative;
    display: flex;
    flex-wrap: nowrap;
    justify-content: center;
    gap: 24px;
    width: fit-content;
    max-width: none;
    margin: 0 auto;
}
.org-row.has-bus::before {
    content: '';
    position: absolute;
    top: 0;
    left: calc(var(--tier-w) / 2);
    right: calc(var(--tier-w) / 2);
    height: 2px;
    background: var(--color-border-secondary);
}

.org-drop {
    width: 2px;
    height: 20px;
    background: var(--color-border-secondary);
}
.org-drop-sm {
    height: 16px;
}
</style>
