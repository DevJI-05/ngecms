<script setup lang="ts">
import type { PortfolioProject } from '@/components/gas/GasPortfolioCard.vue';

defineProps<{ project: PortfolioProject | null }>();
defineEmits<{ close: []; inquiry: [] }>();
</script>

<template>
    <div class="detail-overlay" :class="{ open: project }">
        <div v-if="project" class="detail-box">
            <div class="detail-head">
                <div>
                    <div class="detail-title">{{ project.name }}</div>
                    <div class="detail-sub">
                        {{ project.location }} · {{ project.year }} ·
                        {{ project.client }}
                    </div>
                </div>
                <button
                    class="close-btn"
                    aria-label="Tutup detail"
                    @click="$emit('close')"
                >
                    &#x2715;
                </button>
            </div>
            <div class="detail-body">
                <div class="det-stat-row">
                    <div
                        v-for="(s, i) in project.stats"
                        :key="s"
                        class="det-stat"
                    >
                        <div class="det-stat-num">{{ s }}</div>
                        <div class="det-stat-lbl">
                            {{ project.stat_labels[i] }}
                        </div>
                    </div>
                </div>
                <div class="det-sect">
                    <div class="det-label">Lingkup Pekerjaan</div>
                    <ul class="det-list">
                        <li v-for="s in project.scope" :key="s">
                            <i
                                class="ti ti-check"
                                :style="{ color: project.color }"
                                aria-hidden="true"
                            ></i
                            >{{ s }}
                        </li>
                    </ul>
                </div>
                <div class="det-sect">
                    <div class="det-label">Keunggulan Proyek</div>
                    <ul class="det-list">
                        <li v-for="s in project.highlights" :key="s">
                            <i
                                class="ti ti-star"
                                style="color: #ba7517"
                                aria-hidden="true"
                            ></i
                            >{{ s }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="det-foot">
                <button class="btn-close-det" @click="$emit('close')">
                    Tutup
                </button>
                <button class="btn-inquiry-det" @click="$emit('inquiry')">
                    <i class="ti ti-send" aria-hidden="true"></i> Minta
                    Penawaran Serupa
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.detail-overlay {
    display: none;
    background: rgba(4, 44, 83, 0.92);
    padding: 20px 28px;
    position: fixed;
    inset: 0;
    overflow-y: auto;
    z-index: 50;
}
.detail-overlay.open {
    display: block;
}
.detail-box {
    background: var(--color-background-primary);
    border-radius: var(--border-radius-lg);
    border: 0.5px solid var(--color-border-tertiary);
    overflow: hidden;
    max-width: 600px;
    margin: 0 auto;
}
.detail-head {
    padding: 20px;
    background: #042c53;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
}
.detail-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 22px;
    color: #fff;
    line-height: 1.15;
}
.detail-sub {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.6);
    margin-top: 4px;
}
.close-btn {
    background: rgba(255, 255, 255, 0.12);
    border: none;
    color: #fff;
    font-size: 18px;
    width: 30px;
    height: 30px;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-family: 'Barlow', sans-serif;
}
.detail-body {
    padding: 20px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.det-sect {
    margin-bottom: 4px;
}
.det-label {
    font-size: 10.5px;
    font-weight: 500;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--color-text-tertiary);
    margin-bottom: 7px;
}
.det-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.det-list li {
    font-size: 12.5px;
    color: var(--color-text-secondary);
    display: flex;
    align-items: flex-start;
    gap: 7px;
    line-height: 1.4;
}
.det-list li i {
    font-size: 14px;
    flex-shrink: 0;
    margin-top: 1px;
}
.det-stat-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
    grid-column: 1 / -1;
}
.det-stat {
    background: var(--color-background-secondary);
    border-radius: 6px;
    padding: 10px;
    text-align: center;
}
.det-stat-num {
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 20px;
    color: var(--color-text-primary);
}
.det-stat-lbl {
    font-size: 10px;
    color: var(--color-text-tertiary);
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-top: 2px;
}
.det-foot {
    padding: 14px 20px;
    border-top: 0.5px solid var(--color-border-tertiary);
    display: flex;
    gap: 10px;
    align-items: center;
    justify-content: flex-end;
}
.btn-close-det {
    padding: 8px 16px;
    border-radius: 6px;
    background: var(--color-background-secondary);
    border: 0.5px solid var(--color-border-secondary);
    font-family: 'Barlow', sans-serif;
    font-size: 13px;
    color: var(--color-text-secondary);
    cursor: pointer;
}
.btn-inquiry-det {
    padding: 8px 18px;
    border-radius: 6px;
    background: #185fa5;
    border: none;
    font-family: 'Barlow', sans-serif;
    font-size: 13px;
    color: #fff;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
}

@media (max-width: 640px) {
    .detail-overlay {
        padding: 12px;
    }
    .detail-body {
        grid-template-columns: 1fr;
    }
    .det-stat-row {
        grid-template-columns: repeat(3, 1fr);
    }
    .det-foot {
        flex-wrap: wrap;
    }
    .det-foot button {
        flex: 1;
        justify-content: center;
    }
}
</style>
