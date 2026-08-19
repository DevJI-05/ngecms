<script setup lang="ts">
export interface ServiceDetail {
    cat: string;
    icon: string;
    icon_bg: string;
    icon_color: string;
    name: string;
    tagline: string;
    badge_bg: string;
    badge_color: string;
    badges: string[];
    description: string;
    sections: { title: string; items: string[] }[];
    accent: string;
    foot_note: string;
    prompt: string;
}

defineProps<{ service: ServiceDetail }>();
defineEmits<{ inquiry: [prompt: string] }>();
</script>

<template>
    <div class="service-card" :data-cat="service.cat">
        <div class="sc-head">
            <div
                class="sc-icon"
                :style="{
                    background: service.icon_bg,
                    color: service.icon_color,
                }"
            >
                <i class="ti" :class="service.icon" aria-hidden="true"></i>
            </div>
            <div class="sc-title-block">
                <div class="sc-name">{{ service.name }}</div>
                <div class="sc-tagline">{{ service.tagline }}</div>
                <div class="sc-badges">
                    <span
                        v-for="b in service.badges"
                        :key="b"
                        class="badge"
                        :style="{
                            background: service.badge_bg,
                            color: service.badge_color,
                        }"
                        >{{ b }}</span
                    >
                </div>
            </div>
        </div>
        <div class="sc-body">
            <div class="sc-desc">{{ service.description }}</div>
            <div
                v-for="sect in service.sections"
                :key="sect.title"
                class="sc-section"
            >
                <div class="sc-sect-title">{{ sect.title }}</div>
                <ul class="sc-list">
                    <li v-for="item in sect.items" :key="item">
                        <i
                            class="ti ti-check"
                            :style="{ color: service.accent }"
                            aria-hidden="true"
                        ></i>
                        {{ item }}
                    </li>
                </ul>
            </div>
        </div>
        <div class="sc-foot">
            <div class="sc-foot-note">
                <i
                    class="ti ti-clock"
                    style="font-size: 13px; vertical-align: -2px"
                    aria-hidden="true"
                ></i>
                {{ service.foot_note }}
            </div>
            <button
                class="btn-inquiry"
                :style="{ background: service.accent }"
                @click="$emit('inquiry', service.prompt)"
            >
                <i class="ti ti-send" aria-hidden="true"></i> Minta Penawaran
            </button>
        </div>
    </div>
</template>

<style scoped>
.service-card {
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: var(--border-radius-lg);
    overflow: hidden;
    margin-bottom: 14px;
}
.sc-head {
    padding: 18px 20px 14px;
    border-bottom: 0.5px solid var(--color-border-tertiary);
    display: flex;
    align-items: flex-start;
    gap: 14px;
}
.sc-icon {
    width: 44px;
    height: 44px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}
.sc-title-block {
    flex: 1;
}
.sc-name {
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 19px;
    color: var(--color-text-primary);
    letter-spacing: 0.1px;
    line-height: 1.1;
}
.sc-tagline {
    font-size: 12px;
    color: var(--color-text-secondary);
    margin-top: 3px;
    font-weight: 300;
}
.sc-badges {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-top: 8px;
}
.badge {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    padding: 3px 8px;
    border-radius: 4px;
}
.sc-body {
    padding: 16px 20px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.sc-desc {
    font-size: 13px;
    color: var(--color-text-secondary);
    line-height: 1.65;
    grid-column: 1 / -1;
}
.sc-section {
    margin-top: 2px;
}
.sc-sect-title {
    font-size: 11px;
    font-weight: 500;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--color-text-tertiary);
    margin-bottom: 8px;
}
.sc-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.sc-list li {
    font-size: 12.5px;
    color: var(--color-text-secondary);
    display: flex;
    align-items: flex-start;
    gap: 7px;
    line-height: 1.45;
}
.sc-list li i {
    font-size: 14px;
    flex-shrink: 0;
    margin-top: 1px;
}
.sc-foot {
    padding: 12px 20px;
    background: var(--color-background-secondary);
    border-top: 0.5px solid var(--color-border-tertiary);
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.sc-foot-note {
    font-size: 12px;
    color: var(--color-text-tertiary);
}
.btn-inquiry {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    border-radius: 6px;
    color: #fff;
    font-family: 'Barlow', sans-serif;
    font-size: 12.5px;
    font-weight: 500;
    border: none;
    cursor: pointer;
}
.btn-inquiry:active {
    opacity: 0.85;
}

@media (max-width: 560px) {
    .sc-head {
        flex-direction: column;
    }
    .sc-body {
        grid-template-columns: 1fr;
    }
    .sc-foot {
        flex-direction: column;
        align-items: stretch;
        gap: 8px;
    }
    .btn-inquiry {
        justify-content: center;
    }
}
</style>
