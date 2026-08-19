<script setup lang="ts">
export interface PortfolioProject {
    id: number;
    cat: 'pipeline' | 'cng' | 'maintenance' | 'engineering';
    year: number;
    name: string;
    location: string;
    client: string;
    scale: number;
    specs: string[];
    status: 'done' | 'ongoing';
    icon: string;
    color: string;
    bg_light: string;
    accent_text: string;
    stats: string[];
    stat_labels: string[];
    scope: string[];
    highlights: string[];
}

const props = defineProps<{ project: PortfolioProject }>();
defineEmits<{ open: [id: number] }>();

const catLabels: Record<PortfolioProject['cat'], string> = {
    pipeline: 'Gas Pipeline',
    cng: 'CNG',
    maintenance: 'Maintenance',
    engineering: 'Engineering',
};
const catLabel = catLabels[props.project.cat];
</script>

<template>
    <div class="pcard" @click="$emit('open', project.id)">
        <div class="pcard-img" :style="{ background: project.bg_light }">
            <div class="pcard-img-inner">
                <i
                    class="ti"
                    :class="project.icon"
                    :style="{
                        fontSize: '36px',
                        color: project.color,
                        opacity: 0.18,
                    }"
                    aria-hidden="true"
                ></i>
            </div>
            <span
                class="pcard-cat-badge"
                :style="{ background: project.color, color: '#fff' }"
                >{{ catLabel }}</span
            >
            <span class="pcard-year">{{ project.year }}</span>
        </div>
        <div class="pcard-body">
            <div class="pcard-name">{{ project.name }}</div>
            <div class="pcard-meta">
                <span class="pmeta"
                    ><i class="ti ti-map-pin" aria-hidden="true"></i
                    >{{ project.location }}</span
                >
            </div>
            <div class="pcard-specs">
                <span v-for="s in project.specs" :key="s" class="spec-pill">{{
                    s
                }}</span>
            </div>
        </div>
        <div class="pcard-foot">
            <span
                class="status-pill"
                :class="
                    project.status === 'done' ? 'status-done' : 'status-ongoing'
                "
            >
                <i
                    class="ti"
                    :class="
                        project.status === 'done'
                            ? 'ti-circle-check'
                            : 'ti-progress'
                    "
                    style="font-size: 12px; vertical-align: -1px"
                    aria-hidden="true"
                ></i>
                {{ project.status === 'done' ? 'Selesai' : 'Berlangsung' }}
            </span>
            <span class="pcard-client"
                ><i
                    class="ti ti-building"
                    style="font-size: 13px"
                    aria-hidden="true"
                ></i
                >{{ project.client }}</span
            >
        </div>
    </div>
</template>

<style scoped>
.pcard {
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: var(--border-radius-lg);
    overflow: hidden;
    cursor: pointer;
    transition: border-color 0.2s;
}
.pcard:hover {
    border-color: #378add;
}
.pcard-img {
    height: 110px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}
.pcard-img-inner {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pcard-cat-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 3px 9px;
    border-radius: 4px;
}
.pcard-year {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 10px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.8);
    background: rgba(0, 0, 0, 0.35);
    padding: 3px 8px;
    border-radius: 4px;
}
.pcard-body {
    padding: 14px 16px;
}
.pcard-name {
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 16px;
    color: var(--color-text-primary);
    line-height: 1.2;
    margin-bottom: 5px;
}
.pcard-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 10px;
}
.pmeta {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11.5px;
    color: var(--color-text-secondary);
}
.pmeta i {
    font-size: 13px;
}
.pcard-specs {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}
.spec-pill {
    font-size: 10.5px;
    font-weight: 500;
    padding: 3px 9px;
    border-radius: 4px;
    background: var(--color-background-secondary);
    color: var(--color-text-secondary);
    border: 0.5px solid var(--color-border-tertiary);
}
.pcard-foot {
    padding: 10px 16px;
    border-top: 0.5px solid var(--color-border-tertiary);
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.status-pill {
    font-size: 10.5px;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 4px;
    letter-spacing: 0.5px;
}
.status-done {
    background: #eaf3de;
    color: #27500a;
}
.status-ongoing {
    background: #faeeda;
    color: #633806;
}
.pcard-client {
    font-size: 11.5px;
    color: var(--color-text-tertiary);
    display: flex;
    align-items: center;
    gap: 4px;
}
</style>
