<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { computed, nextTick, onMounted, onUnmounted, ref, watch } from 'vue';
import GasBtnOutline from '@/components/gas/GasBtnOutline.vue';
import GasBtnPrimary from '@/components/gas/GasBtnPrimary.vue';
import GasBtnWa from '@/components/gas/GasBtnWa.vue';
import GasCtaStrip from '@/components/gas/GasCtaStrip.vue';
import GasFooter from '@/components/gas/GasFooter.vue';
import GasHero from '@/components/gas/GasHero.vue';
import GasNavbar from '@/components/gas/GasNavbar.vue';
import GasStatBox from '@/components/gas/GasStatBox.vue';
import GasTimelineItem from '@/components/gas/GasTimelineItem.vue';
import GasValueCard from '@/components/gas/GasValueCard.vue';
import OrgChartNode from '@/components/gas/OrgChartNode.vue';
import { buildOrgTree, rowWidth, type OrgTreeMember } from '@/lib/orgTree';
import { openWhatsApp } from '@/lib/whatsapp';
import { certifications, contact } from '@/routes';

interface TeamMember extends OrgTreeMember {
    parent_id: number | null;
}

const props = defineProps<{
    values: {
        icon: string;
        name: string;
        description: string;
        accent: string;
    }[];
    timeline: {
        year_label: string;
        dot_color: string;
        badge: string;
        badge_bg: string;
        badge_color: string;
        name: string;
        description: string;
    }[];
    teamMembers: TeamMember[];
    settings: {
        established_year: number;
        whatsapp_number: string;
    };
    stats: {
        projectsCompleted: string;
        employees: string;
        provinces: string;
    };
}>();

const tabs = [
    { id: 'profil', label: 'Profil Perusahaan' },
    { id: 'timeline', label: 'Sejarah & Pencapaian' },
    { id: 'org', label: 'Struktur Organisasi' },
];
const activeTab = ref('profil');

// The org chart has no fixed number of tiers — it's built from whatever
// `parent_id` chains the team members form, to unlimited depth.
const orgRoots = computed(() => buildOrgTree(props.teamMembers));
const orgRootRowWidth = computed(() => rowWidth(orgRoots.value, 0));

// The org chart is wider than a mobile screen and keeps its full desktop
// size — instead of shrinking cards or wrapping the directors row into a
// misleading chain, it lives on a pannable/pinch-zoomable canvas on mobile
// so people can drag and pinch to explore it, same as a map. Desktop
// already fits it comfortably, so it stays a plain, centered, static
// layout there — no drag/zoom behavior needed or wanted.
const ORG_ZOOM_MIN = 0.5;
const ORG_ZOOM_MAX = 2.5;
const ORG_MOBILE_QUERY = '(max-width: 768px)';

const isMobileView = ref(false);
let orgMql: MediaQueryList | undefined;
function updateIsMobileView() {
    isMobileView.value = orgMql?.matches ?? false;
}

const orgCanvasEl = ref<HTMLElement | null>(null);
const orgContentEl = ref<HTMLElement | null>(null);
const orgZoom = ref(1);
const orgPan = ref({ x: 0, y: 0 });
const orgDefaultPan = ref({ x: 0, y: 0 });
const orgIsDirty = computed(
    () =>
        orgZoom.value !== 1 ||
        orgPan.value.x !== orgDefaultPan.value.x ||
        orgPan.value.y !== orgDefaultPan.value.y,
);

// Komisaris Utama and Direktur Utama sit at the horizontal center of the
// chart (the directors row below them is what makes the chart wider than
// the canvas). So the default view always centers the chart — never
// flush-left — otherwise the first thing people see on mobile is whichever
// director happens to be on the left edge instead of the top of the
// hierarchy.
function computeDefaultPan() {
    const canvas = orgCanvasEl.value;
    const content = orgContentEl.value;

    if (!isMobileView.value || !canvas || !content) {
        return { x: 0, y: 0 };
    }

    const canvasWidth = canvas.clientWidth;
    const contentWidth = content.scrollWidth;

    return {
        x: (canvasWidth - contentWidth) / 2,
        y: 0,
    };
}

const orgAnimating = ref(false);
function resetOrgView() {
    orgAnimating.value = true;
    orgZoom.value = 1;
    orgDefaultPan.value = computeDefaultPan();
    orgPan.value = { ...orgDefaultPan.value };
    setTimeout(() => {
        orgAnimating.value = false;
    }, 220);
}

function clampZoom(z: number) {
    return Math.min(ORG_ZOOM_MAX, Math.max(ORG_ZOOM_MIN, z));
}

function touchDistance(a: Touch, b: Touch) {
    return Math.hypot(a.clientX - b.clientX, a.clientY - b.clientY);
}

type OrgTouchState =
    | { mode: 'pan'; startX: number; startY: number; startPan: { x: number; y: number } }
    | {
          mode: 'pinch';
          startDist: number;
          startZoom: number;
          startPan: { x: number; y: number };
      };

let orgTouchState: OrgTouchState | null = null;

function onOrgTouchStart(e: TouchEvent) {
    if (!isMobileView.value) {
        return;
    }

    if (e.touches.length === 1) {
        orgTouchState = {
            mode: 'pan',
            startX: e.touches[0].clientX,
            startY: e.touches[0].clientY,
            startPan: { ...orgPan.value },
        };
    } else if (e.touches.length === 2) {
        orgTouchState = {
            mode: 'pinch',
            startDist: touchDistance(e.touches[0], e.touches[1]),
            startZoom: orgZoom.value,
            startPan: { ...orgPan.value },
        };
    }
}

function onOrgTouchMove(e: TouchEvent) {
    if (!orgTouchState) {
        return;
    }

    e.preventDefault();

    if (orgTouchState.mode === 'pan' && e.touches.length === 1) {
        const dx = e.touches[0].clientX - orgTouchState.startX;
        const dy = e.touches[0].clientY - orgTouchState.startY;
        orgPan.value = {
            x: orgTouchState.startPan.x + dx,
            y: orgTouchState.startPan.y + dy,
        };
    } else if (orgTouchState.mode === 'pinch' && e.touches.length === 2) {
        const dist = touchDistance(e.touches[0], e.touches[1]);
        orgZoom.value = clampZoom(
            orgTouchState.startZoom * (dist / orgTouchState.startDist),
        );
    }
}

function onOrgTouchEnd(e: TouchEvent) {
    if (e.touches.length === 1) {
        orgTouchState = {
            mode: 'pan',
            startX: e.touches[0].clientX,
            startY: e.touches[0].clientY,
            startPan: { ...orgPan.value },
        };
    } else {
        orgTouchState = null;
    }
}

let orgResizeTimeout: ReturnType<typeof setTimeout> | undefined;
function onOrgWindowResize() {
    if (activeTab.value !== 'org') {
        return;
    }

    clearTimeout(orgResizeTimeout);
    orgResizeTimeout = setTimeout(resetOrgView, 150);
}

onMounted(() => {
    orgMql = window.matchMedia(ORG_MOBILE_QUERY);
    updateIsMobileView();
    orgMql.addEventListener('change', updateIsMobileView);
    window.addEventListener('resize', onOrgWindowResize);
});
onUnmounted(() => {
    orgMql?.removeEventListener('change', updateIsMobileView);
    window.removeEventListener('resize', onOrgWindowResize);
    clearTimeout(orgResizeTimeout);
});
watch(activeTab, (tab) => {
    if (tab === 'org') {
        nextTick(resetOrgView);
    }
});
watch(isMobileView, () => {
    if (activeTab.value === 'org') {
        nextTick(resetOrgView);
    }
});
</script>

<template>
    <Head title="Tentang Kami — Nusantara Gas Energy" />

    <div class="nge pg">
        <GasHero
            badge="Tentang Kami"
            description="Lebih dari 15 tahun membangun infrastruktur gas bumi Indonesia — dari Jawa, Sumatera, hingga Kalimantan. Bersertifikat, berpengalaman, dan berkomitmen pada keselamatan."
        >
            <template #navbar>
                <GasNavbar active="about" variant="hero" />
            </template>
            <template #title>
                Membangun Infrastruktur<br /><span>Gas Bumi Indonesia</span>
            </template>
            <template #buttons>
                <GasBtnPrimary
                    icon="ti-certificate"
                    text-color="#042C53"
                    @click="router.visit(certifications())"
                >
                    Lihat Sertifikasi
                </GasBtnPrimary>
                <GasBtnOutline icon="ti-sitemap" @click="activeTab = 'org'">
                    Struktur Organisasi
                </GasBtnOutline>
            </template>
            <template #stats>
                <GasStatBox
                    :num="String(settings.established_year)"
                    label="Berdiri"
                />
                <GasStatBox :num="stats.projectsCompleted" label="Proyek" />
                <GasStatBox :num="stats.employees" label="Karyawan" />
                <GasStatBox :num="stats.provinces" label="Provinsi" />
            </template>
        </GasHero>

        <div class="tab-nav">
            <button
                v-for="t in tabs"
                :key="t.id"
                class="tnav"
                :class="{ on: activeTab === t.id }"
                @click="activeTab = t.id"
            >
                {{ t.label }}
            </button>
        </div>

        <!-- PROFIL -->
        <div v-show="activeTab === 'profil'" class="section">
            <div class="profil-grid">
                <div style="display: flex; flex-direction: column; gap: 14px">
                    <div class="prose-card">
                        <div class="prose-label">Tentang Perusahaan</div>
                        <div class="prose-title">
                            Spesialis Gas Bumi Terpercaya di Indonesia
                        </div>
                        <div class="prose-body">
                            <p>
                                PT. Nusantara Gas Energy didirikan pada tahun
                                2008 di Jakarta sebagai perusahaan Engineering,
                                Procurement & Construction (EPC) yang fokus pada
                                infrastruktur gas bumi. Bermula dari tim kecil
                                12 engineer berpengalaman, kini kami telah
                                berkembang menjadi salah satu kontraktor gas
                                pipeline dan CNG terkemuka di Indonesia dengan
                                lebih dari 350 karyawan tetap.
                            </p>
                            <p>
                                Kami melayani klien dari berbagai segmen — mulai
                                dari perusahaan minyak dan gas nasional seperti
                                PGN dan Pertamina, kawasan industri, pemerintah
                                daerah, hingga perusahaan swasta yang
                                membutuhkan solusi energi gas bumi yang andal
                                dan efisien.
                            </p>
                            <p>
                                Dengan rekam jejak lebih dari 200 proyek
                                selesai, panjang pipeline terpasang lebih dari
                                500 km, dan fasilitas CNG yang tersebar di 15
                                provinsi, kami bangga menjadi bagian dari pilar
                                ketahanan energi nasional.
                            </p>
                        </div>
                    </div>

                    <div class="nilai-grid">
                        <GasValueCard
                            v-for="v in values"
                            :key="v.name"
                            :icon="v.icon"
                            :name="v.name"
                            :desc="v.description"
                            :accent="v.accent"
                        />
                    </div>
                </div>

                <div class="mv-stack">
                    <div class="mv-card">
                        <div
                            class="mv-icon"
                            style="background: #e6f1fb; color: #185fa5"
                        >
                            <i class="ti ti-eye" aria-hidden="true"></i>
                        </div>
                        <div class="mv-title">Visi</div>
                        <div class="mv-body">
                            Menjadi perusahaan EPC gas bumi terkemuka dan
                            terpercaya di Asia Tenggara pada tahun 2030, dengan
                            kontribusi nyata terhadap ketahanan energi nasional
                            dan transisi menuju energi bersih.
                        </div>
                    </div>
                    <div class="mv-card">
                        <div
                            class="mv-icon"
                            style="background: #faeeda; color: #ba7517"
                        >
                            <i class="ti ti-target" aria-hidden="true"></i>
                        </div>
                        <div class="mv-title">Misi</div>
                        <div class="mv-body">
                            <ul
                                style="
                                    list-style: none;
                                    display: flex;
                                    flex-direction: column;
                                    gap: 6px;
                                "
                            >
                                <li
                                    style="
                                        display: flex;
                                        gap: 7px;
                                        font-size: 12.5px;
                                        color: var(--color-text-secondary);
                                        line-height: 1.5;
                                    "
                                >
                                    <i
                                        class="ti ti-check"
                                        style="
                                            color: #ba7517;
                                            font-size: 14px;
                                            flex-shrink: 0;
                                            margin-top: 1px;
                                        "
                                        aria-hidden="true"
                                    ></i
                                    >Membangun infrastruktur gas bumi
                                    berkualitas tinggi
                                </li>
                                <li
                                    style="
                                        display: flex;
                                        gap: 7px;
                                        font-size: 12.5px;
                                        color: var(--color-text-secondary);
                                        line-height: 1.5;
                                    "
                                >
                                    <i
                                        class="ti ti-check"
                                        style="
                                            color: #ba7517;
                                            font-size: 14px;
                                            flex-shrink: 0;
                                            margin-top: 1px;
                                        "
                                        aria-hidden="true"
                                    ></i
                                    >Mengutamakan keselamatan dan lingkungan
                                </li>
                                <li
                                    style="
                                        display: flex;
                                        gap: 7px;
                                        font-size: 12.5px;
                                        color: var(--color-text-secondary);
                                        line-height: 1.5;
                                    "
                                >
                                    <i
                                        class="ti ti-check"
                                        style="
                                            color: #ba7517;
                                            font-size: 14px;
                                            flex-shrink: 0;
                                            margin-top: 1px;
                                        "
                                        aria-hidden="true"
                                    ></i
                                    >Mengembangkan SDM profesional & kompeten
                                </li>
                                <li
                                    style="
                                        display: flex;
                                        gap: 7px;
                                        font-size: 12.5px;
                                        color: var(--color-text-secondary);
                                        line-height: 1.5;
                                    "
                                >
                                    <i
                                        class="ti ti-check"
                                        style="
                                            color: #ba7517;
                                            font-size: 14px;
                                            flex-shrink: 0;
                                            margin-top: 1px;
                                        "
                                        aria-hidden="true"
                                    ></i
                                    >Memberikan nilai tambah bagi klien &
                                    pemangku kepentingan
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="mv-card">
                        <div
                            class="mv-icon"
                            style="background: #eaf3de; color: #3b6d11"
                        >
                            <i class="ti ti-map-pin" aria-hidden="true"></i>
                        </div>
                        <div class="mv-title">Kantor & Wilayah Operasi</div>
                        <div
                            class="mv-body"
                            style="
                                font-size: 12.5px;
                                color: var(--color-text-secondary);
                                line-height: 1.6;
                            "
                        >
                            <strong
                                style="
                                    color: var(--color-text-primary);
                                    display: block;
                                    margin-bottom: 4px;
                                "
                                >Kantor Pusat</strong
                            >
                            Gedung Menara Gas Lt. 8, Jl. TB Simatupang No. 45,
                            Jakarta Selatan
                            <strong
                                style="
                                    color: var(--color-text-primary);
                                    display: block;
                                    margin: 8px 0 4px;
                                "
                                >Kantor Cabang</strong
                            >
                            Surabaya · Palembang · Balikpapan · Medan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TIMELINE -->
        <div v-show="activeTab === 'timeline'" class="section">
            <div class="timeline-wrap">
                <div class="timeline-line"></div>
                <GasTimelineItem
                    v-for="t in timeline"
                    :key="t.name"
                    :year="t.year_label"
                    :dot-color="t.dot_color"
                    :badge="t.badge"
                    :badge-bg="t.badge_bg"
                    :badge-color="t.badge_color"
                    :name="t.name"
                    :desc="t.description"
                />
            </div>
        </div>

        <!-- STRUKTUR ORG -->
        <div v-show="activeTab === 'org'" class="section">
            <div
                class="org-canvas"
                :class="{ 'is-interactive': isMobileView }"
                ref="orgCanvasEl"
                @touchstart="onOrgTouchStart"
                @touchmove="onOrgTouchMove"
                @touchend="onOrgTouchEnd"
                @touchcancel="onOrgTouchEnd"
            >
                <button
                    v-if="isMobileView && orgIsDirty"
                    type="button"
                    class="org-reset-btn"
                    @click="resetOrgView"
                >
                    <i class="ti ti-refresh-alert" aria-hidden="true"></i>
                    Reset
                </button>
                <div v-if="isMobileView" class="org-hint">
                    <i class="ti ti-arrows-move" aria-hidden="true"></i>
                    Geser & cubit untuk zoom
                </div>
                <div
                    class="org-wrap"
                    :class="{ 'org-anim': orgAnimating }"
                    ref="orgContentEl"
                    :style="
                        isMobileView
                            ? {
                                  transform: `translate(${orgPan.x}px, ${orgPan.y}px) scale(${orgZoom})`,
                              }
                            : {}
                    "
                >
                <div
                    class="org-row"
                    :class="{ 'has-bus': orgRoots.length > 1 }"
                    :style="{ '--tier-w': orgRootRowWidth + 'px' }"
                >
                    <OrgChartNode
                        v-for="root in orgRoots"
                        :key="root.member.id"
                        :node="root"
                        :depth="0"
                    />
                </div>
                </div>
            </div>
        </div>

        <GasCtaStrip
            text="Ingin bergabung atau bermitra dengan kami?"
            sub="Tersedia posisi engineer & konsultasi kemitraan terbuka"
        >
            <GasBtnWa
                @click="
                    openWhatsApp(
                        'Halo, saya ingin bertanya tentang peluang kemitraan / karier di Nusantara Gas Energy.',
                        settings.whatsapp_number,
                    )
                "
                >Chat WA</GasBtnWa
            >
            <GasBtnPrimary icon="ti-mail" @click="router.visit(contact())"
                >Hubungi Kami</GasBtnPrimary
            >
        </GasCtaStrip>

        <GasFooter />
    </div>
</template>

<style scoped>
.pg {
    font-family: 'Barlow', sans-serif;
    color: var(--color-text-primary);
    background: var(--color-background-tertiary);
}

/* TAB NAV */
.tab-nav {
    background: var(--color-background-primary);
    border-bottom: 0.5px solid var(--color-border-tertiary);
    padding: 0 28px;
    display: flex;
    gap: 0;
    overflow-x: auto;
}
.tnav {
    padding: 13px 18px;
    font-size: 12.5px;
    font-weight: 500;
    color: var(--color-text-secondary);
    border: none;
    background: transparent;
    cursor: pointer;
    border-bottom: 2.5px solid transparent;
    font-family: 'Barlow', sans-serif;
    white-space: nowrap;
}
.tnav.on {
    color: #185fa5;
    border-bottom-color: #185fa5;
}

.section {
    padding: 24px 28px;
}

/* PROFIL */
.profil-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 260px;
    gap: 20px;
}
.prose-card {
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: var(--border-radius-lg);
    padding: 22px;
}
.prose-label {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #185fa5;
    margin-bottom: 6px;
}
.prose-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 22px;
    color: var(--color-text-primary);
    margin-bottom: 12px;
    letter-spacing: 0.1px;
}
.prose-body {
    font-size: 13px;
    color: var(--color-text-secondary);
    line-height: 1.75;
}
.prose-body p {
    margin-bottom: 10px;
}
.prose-body p:last-child {
    margin-bottom: 0;
}
.mv-stack {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.mv-card {
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: var(--border-radius-lg);
    padding: 16px;
}
.mv-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-bottom: 10px;
}
.mv-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 16px;
    color: var(--color-text-primary);
    margin-bottom: 6px;
}
.mv-body {
    font-size: 12.5px;
    color: var(--color-text-secondary);
    line-height: 1.6;
}

.nilai-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-top: 16px;
}

/* TIMELINE */
.timeline-wrap {
    max-width: 700px;
    margin: 0 auto;
    position: relative;
    padding-left: 32px;
}
.timeline-line {
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #185fa5, #ef9f27, #3b6d11);
}

/* STRUKTUR ORGANISASI */
.org-canvas {
    position: relative;
    display: flex;
    justify-content: center;
    border-radius: var(--border-radius-lg);
    border: 0.5px solid var(--color-border-tertiary);
}
/* Drag/pinch-zoom is a mobile-only affordance — desktop already fits the
   whole chart, so it stays a plain, static, centered layout. */
.org-canvas.is-interactive {
    display: block;
    overflow: hidden;
    touch-action: none;
    cursor: grab;
    user-select: none;
}
.org-canvas.is-interactive:active {
    cursor: grabbing;
}

.org-reset-btn {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    font-size: 11.5px;
    font-weight: 600;
    color: var(--color-text-primary);
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: 999px;
    box-shadow: 0 2px 8px rgba(16, 35, 58, 0.15);
    cursor: pointer;
}

.org-hint {
    position: absolute;
    top: 12px;
    left: 12px;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 5px 10px;
    font-size: 10.5px;
    color: var(--color-text-tertiary);
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: 999px;
    opacity: 0.85;
    pointer-events: none;
}

.org-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0;
    padding: 40px 24px;
    background:
        radial-gradient(
            circle at 1px 1px,
            var(--color-border-tertiary) 1px,
            transparent 0
        )
        0 0 / 22px 22px,
        var(--color-background-secondary);
    transform-origin: center top;
    width: max-content;
    max-width: none;
}
.org-wrap.org-anim {
    transition: transform 0.2s ease;
}

/* The tree itself (cards, tiers, connector lines) is rendered by the
   recursive OrgChartNode component. Only the outermost row — the chart's
   root(s) — is laid out here, reusing the same --tier-w/has-bus convention
   so the connector line centers correctly above however many roots there
   are (almost always exactly one). */
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

@media (max-width: 900px) {
    .profil-grid {
        grid-template-columns: 1fr;
    }
    .nilai-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .section {
        padding: 20px;
    }
    .tab-nav {
        padding: 0 20px;
    }
    .timeline-wrap {
        padding-left: 24px;
    }
}

@media (max-width: 560px) {
    .nilai-grid {
        grid-template-columns: 1fr;
    }
    .prose-title {
        font-size: 19px;
    }
}
</style>
