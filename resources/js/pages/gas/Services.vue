<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import GasBtnPrimary from '@/components/gas/GasBtnPrimary.vue';
import GasBtnWa from '@/components/gas/GasBtnWa.vue';
import GasCtaStrip from '@/components/gas/GasCtaStrip.vue';
import GasFooter from '@/components/gas/GasFooter.vue';
import GasNavbar from '@/components/gas/GasNavbar.vue';
import GasServiceDetailCard from '@/components/gas/GasServiceDetailCard.vue';
import type { ServiceDetail } from '@/components/gas/GasServiceDetailCard.vue';
import GasStatBox from '@/components/gas/GasStatBox.vue';
import { openWhatsApp } from '@/lib/whatsapp';

const props = defineProps<{
    services: ServiceDetail[];
    stats: {
        serviceCount: number;
        pipelineKm: string;
        projectsCompleted: string;
    };
}>();

const filters = [
    { id: 'all', label: 'Semua Layanan' },
    { id: 'pipeline', label: 'Gas Pipeline' },
    { id: 'cng', label: 'CNG' },
    { id: 'maintenance', label: 'Maintenance' },
    { id: 'engineering', label: 'Engineering' },
    { id: 'safety', label: 'Safety & HSE' },
];
const activeFilter = ref('all');

const visibleServices = computed(() =>
    props.services.filter(
        (s) => activeFilter.value === 'all' || s.cat === activeFilter.value,
    ),
);

function inquiryAbout(prompt: string) {
    openWhatsApp(prompt);
}
</script>

<template>
    <Head title="Layanan Kami — Nusantara Gas Energy" />

    <div class="nge pg">
        <GasNavbar active="services" variant="topbar" />

        <div class="hero-strip">
            <div class="hero-inner">
                <div class="hero-left">
                    <div class="breadcrumb">
                        Beranda &rsaquo; <span>Layanan</span>
                    </div>
                    <div class="page-title">Layanan Kami</div>
                    <div class="page-sub">
                        Solusi gas bumi terpadu dari perencanaan, konstruksi,
                        hingga operasional dan pemeliharaan — bersertifikat
                        MIGAS dan berpengalaman lebih dari 15 tahun.
                    </div>
                </div>
                <div class="stat-row">
                    <GasStatBox
                        size="lg"
                        :num="String(stats.serviceCount)"
                        label="Jenis Layanan"
                    />
                    <GasStatBox
                        size="lg"
                        :num="stats.pipelineKm"
                        label="Pipeline"
                    />
                    <GasStatBox
                        size="lg"
                        :num="stats.projectsCompleted"
                        label="Proyek"
                    />
                </div>
            </div>
        </div>

        <div class="filter-bar">
            <button
                v-for="f in filters"
                :key="f.id"
                class="ftab"
                :class="{ on: activeFilter === f.id }"
                @click="activeFilter = f.id"
            >
                {{ f.label }}
            </button>
        </div>

        <div class="content-area">
            <div id="svc-list">
                <GasServiceDetailCard
                    v-for="s in visibleServices"
                    :key="s.name"
                    :service="s"
                    @inquiry="inquiryAbout"
                />
            </div>

            <div class="sidebar">
                <div class="side-card">
                    <div class="side-title">
                        <i
                            class="ti ti-award"
                            style="font-size: 16px; color: #ef9f27"
                            aria-hidden="true"
                        ></i>
                        Sertifikasi & Izin
                    </div>
                    <div class="cert-grid">
                        <div class="cert-pill">
                            <div class="cert-name">BPH MIGAS</div>
                            <div class="cert-sub">Konstruksi & Operasi</div>
                        </div>
                        <div class="cert-pill">
                            <div class="cert-name">ISO 9001</div>
                            <div class="cert-sub">:2015</div>
                        </div>
                        <div class="cert-pill">
                            <div class="cert-name">OHSAS</div>
                            <div class="cert-sub">18001</div>
                        </div>
                        <div class="cert-pill">
                            <div class="cert-name">IUJPTL</div>
                            <div class="cert-sub">Instalasi Gas</div>
                        </div>
                    </div>
                </div>

                <div class="side-card">
                    <div class="side-title">
                        <i
                            class="ti ti-users"
                            style="font-size: 16px; color: #185fa5"
                            aria-hidden="true"
                        ></i>
                        Mengapa kami?
                    </div>
                    <div class="side-item">
                        <div
                            class="side-dot"
                            style="background: #e6f1fb; color: #185fa5"
                        >
                            <i
                                class="ti ti-shield"
                                style="font-size: 14px"
                                aria-hidden="true"
                            ></i>
                        </div>
                        <div class="side-text">
                            <strong>Zero accident record</strong>Lebih dari 3
                            juta man-hours tanpa kecelakaan fatal
                        </div>
                    </div>
                    <div class="side-item">
                        <div
                            class="side-dot"
                            style="background: #eaf3de; color: #3b6d11"
                        >
                            <i
                                class="ti ti-clock"
                                style="font-size: 14px"
                                aria-hidden="true"
                            ></i>
                        </div>
                        <div class="side-text">
                            <strong>On-time delivery</strong>96% proyek selesai
                            tepat waktu sejak 2019
                        </div>
                    </div>
                    <div class="side-item">
                        <div
                            class="side-dot"
                            style="background: #faeeda; color: #ba7517"
                        >
                            <i
                                class="ti ti-tool"
                                style="font-size: 14px"
                                aria-hidden="true"
                            ></i>
                        </div>
                        <div class="side-text">
                            <strong>Peralatan sendiri</strong>Armada alat berat
                            & ILI tool milik perusahaan
                        </div>
                    </div>
                    <div class="side-item">
                        <div
                            class="side-dot"
                            style="background: #e1f5ee; color: #0f6e56"
                        >
                            <i
                                class="ti ti-headset"
                                style="font-size: 14px"
                                aria-hidden="true"
                            ></i>
                        </div>
                        <div class="side-text">
                            <strong>Dukungan purna jual</strong>Tim after-sales
                            & emergency 24/7 siap merespons
                        </div>
                    </div>
                </div>

                <div class="side-card">
                    <div class="side-title">
                        <i
                            class="ti ti-building"
                            style="font-size: 16px; color: #534ab7"
                            aria-hidden="true"
                        ></i>
                        Klien & Mitra
                    </div>
                    <div class="side-item">
                        <div
                            class="side-dot"
                            style="background: #e6f1fb; color: #185fa5"
                        >
                            <i
                                class="ti ti-briefcase"
                                style="font-size: 14px"
                                aria-hidden="true"
                            ></i>
                        </div>
                        <div class="side-text">
                            <strong>PGN / Pertamina Gas</strong>Sub-kontraktor
                            jaringan distribusi
                        </div>
                    </div>
                    <div class="side-item">
                        <div
                            class="side-dot"
                            style="background: #eaf3de; color: #3b6d11"
                        >
                            <i
                                class="ti ti-building-factory"
                                style="font-size: 14px"
                                aria-hidden="true"
                            ></i>
                        </div>
                        <div class="side-text">
                            <strong>Kawasan Industri MM2100</strong
                            >Infrastruktur gas kawasan
                        </div>
                    </div>
                    <div class="side-item">
                        <div
                            class="side-dot"
                            style="background: #faeeda; color: #ba7517"
                        >
                            <i
                                class="ti ti-bolt"
                                style="font-size: 14px"
                                aria-hidden="true"
                            ></i>
                        </div>
                        <div class="side-text">
                            <strong>PLN Batam</strong>Fuel gas supply sistem
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <GasCtaStrip
            text="Siap berdiskusi tentang proyek Anda?"
            sub="Konsultasi teknis gratis — tim engineer kami siap merespons dalam 24 jam"
        >
            <GasBtnWa
                @click="
                    openWhatsApp(
                        'Buatkan template pesan WhatsApp untuk inquiry proyek gas pipeline dan CNG ke tim sales',
                    )
                "
                >Chat WA</GasBtnWa
            >
            <GasBtnPrimary
                icon="ti-file-description"
                @click="
                    openWhatsApp(
                        'Buatkan form inquiry proyek gas pipeline dan CNG',
                    )
                "
                >Minta Penawaran</GasBtnPrimary
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

.hero-strip {
    background: #0c447c;
    padding: 28px 28px 0;
    border-bottom: 3px solid #ef9f27;
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
.hero-inner {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
}
.hero-left {
    padding-bottom: 28px;
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
    max-width: 420px;
    line-height: 1.55;
}
.stat-row {
    display: flex;
    gap: 0;
}

.filter-bar {
    background: var(--color-background-primary);
    padding: 0 28px;
    border-bottom: 0.5px solid var(--color-border-tertiary);
    display: flex;
    gap: 0;
    overflow-x: auto;
}
.ftab {
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
.ftab.on {
    color: #185fa5;
    border-bottom-color: #185fa5;
}

.content-area {
    padding: 24px 28px;
    display: grid;
    grid-template-columns: minmax(0, 1fr) 220px;
    gap: 20px;
}

.sidebar {
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.side-card {
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: var(--border-radius-lg);
    padding: 16px;
}
.side-title {
    font-size: 12px;
    font-weight: 500;
    color: var(--color-text-primary);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.side-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 9px 0;
    border-bottom: 0.5px solid var(--color-border-tertiary);
}
.side-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.side-dot {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 14px;
}
.side-text {
    font-size: 12px;
    color: var(--color-text-secondary);
    line-height: 1.45;
}
.side-text :deep(strong) {
    display: block;
    color: var(--color-text-primary);
    font-weight: 500;
    font-size: 12.5px;
    margin-bottom: 1px;
}

.cert-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 7px;
}
.cert-pill {
    background: var(--color-background-secondary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: 6px;
    padding: 7px 10px;
    text-align: center;
}
.cert-name {
    font-size: 11.5px;
    font-weight: 500;
    color: var(--color-text-primary);
}
.cert-sub {
    font-size: 10px;
    color: var(--color-text-tertiary);
}

@media (max-width: 900px) {
    .content-area {
        grid-template-columns: 1fr;
    }
    .sidebar {
        order: 2;
    }
}

@media (max-width: 640px) {
    .hero-strip {
        padding: 22px 20px 0;
    }
    .hero-inner {
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
    }
    .hero-left {
        padding-bottom: 20px;
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
    .filter-bar {
        padding: 0 20px;
    }
    .content-area {
        padding: 20px;
    }
}
</style>
