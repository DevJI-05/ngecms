<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import GasBtnOutline from '@/components/gas/GasBtnOutline.vue';
import GasBtnPrimary from '@/components/gas/GasBtnPrimary.vue';
import GasFooter from '@/components/gas/GasFooter.vue';
import GasHero from '@/components/gas/GasHero.vue';
import GasNavbar from '@/components/gas/GasNavbar.vue';
import GasProjectMiniCard from '@/components/gas/GasProjectMiniCard.vue';
import GasServiceMiniCard from '@/components/gas/GasServiceMiniCard.vue';
import GasStatBox from '@/components/gas/GasStatBox.vue';
import {
    contact,
    inquiry,
    portfolio,
    services as servicesRoute,
} from '@/routes';

const props = defineProps<{
    services: {
        icon: string;
        icon_bg: string;
        icon_color: string;
        name: string;
        description: string;
    }[];
    projects: {
        cat: string;
        name: string;
        location: string;
        year: number;
        specs: string[];
    }[];
    stats: {
        projectsCompleted: string;
        pipelineKm: string;
        yearsExperience: string;
    };
}>();

const tickerItems = [
    'Bersertifikat BPH MIGAS',
    'ISO 9001:2015',
    'OHSAS 18001',
    'Member APINDO',
    'Rekanan PLN & PGN',
    '24/7 Emergency Response',
];

const projectCards = computed(() =>
    props.projects.map((p) => ({
        tag:
            p.cat === 'cng'
                ? 'CNG Station'
                : p.cat === 'maintenance'
                  ? 'Maintenance'
                  : p.cat === 'engineering'
                    ? 'Engineering'
                    : 'Gas Pipeline',
        name: p.name,
        info: `${p.specs[0] ?? ''} · ${p.year} · ${p.location}`,
        cng: p.cat === 'cng',
    })),
);

const serviceCards = computed(() =>
    props.services.map((s) => ({
        icon: s.icon,
        iconBg: s.icon_bg,
        iconColor: s.icon_color,
        title: s.name,
        desc: s.description,
    })),
);
</script>

<template>
    <Head title="Nusantara Gas Energy — Solusi Infrastruktur Gas Bumi" />

    <div class="nge nge-root">
        <GasHero
            badge="Solusi Energi Gas Bumi"
            description="Spesialis pipeline gas bumi dan Compressed Natural Gas (CNG) untuk industri, komersial, dan transportasi. Bersertifikat MIGAS dengan pengalaman lebih dari 15 tahun."
        >
            <template #navbar>
                <GasNavbar active="home" variant="hero" />
            </template>
            <template #title>
                Infrastruktur Gas<br /><span>Handal &amp; Efisien</span>
            </template>
            <template #buttons>
                <GasBtnPrimary
                    icon="ti-file-description"
                    text-color="#042C53"
                    @click="router.visit(servicesRoute())"
                >
                    Lihat Layanan
                </GasBtnPrimary>
                <GasBtnOutline @click="router.visit(portfolio())"
                    >Portofolio Proyek</GasBtnOutline
                >
            </template>
            <template #stats>
                <GasStatBox
                    :num="props.stats.projectsCompleted"
                    label="Proyek Selesai"
                />
                <GasStatBox
                    :num="props.stats.pipelineKm"
                    label="Pipeline Terpasang"
                />
                <GasStatBox
                    :num="props.stats.yearsExperience"
                    label="Tahun Pengalaman"
                />
            </template>
        </GasHero>

        <div class="ticker">
            <div v-for="item in tickerItems" :key="item" class="ticker-item">
                <span class="ticker-dot"></span> {{ item }}
            </div>
        </div>

        <div class="services">
            <p class="section-label">Layanan Utama</p>
            <h2 class="section-title">Solusi Gas Bumi Terpadu</h2>
            <div class="services-grid">
                <GasServiceMiniCard
                    v-for="s in serviceCards"
                    :key="s.title"
                    v-bind="s"
                />
            </div>
        </div>

        <div class="projects">
            <p class="section-label">Portofolio</p>
            <h2 class="section-title">Proyek Unggulan</h2>
            <div class="projects-grid">
                <GasProjectMiniCard
                    v-for="p in projectCards"
                    :key="p.name"
                    v-bind="p"
                />
            </div>
        </div>

        <div class="contact-bar">
            <div>
                <div class="contact-text">Siap Konsultasi Proyek Gas Anda?</div>
                <div class="contact-sub">
                    Tim engineering kami siap memberikan solusi terbaik
                </div>
            </div>
            <div class="contact-actions">
                <GasBtnOutline icon="ti-phone" @click="router.visit(contact())"
                    >Telepon</GasBtnOutline
                >
                <GasBtnPrimary
                    icon="ti-brand-whatsapp"
                    @click="router.visit(inquiry())"
                    >Chat WhatsApp</GasBtnPrimary
                >
            </div>
        </div>

        <GasFooter />
    </div>
</template>

<style scoped>
.nge-root {
    font-family: 'Barlow', sans-serif;
    color: var(--color-text-primary);
    background: var(--color-background-tertiary);
    overflow: hidden;
}

.ticker {
    background: #0c447c;
    border-top: 2px solid #ef9f27;
    padding: 10px 32px;
    display: flex;
    gap: 32px;
    overflow: hidden;
}

.ticker-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: rgba(255, 255, 255, 0.7);
    white-space: nowrap;
    font-weight: 500;
    letter-spacing: 0.5px;
}

.ticker-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #ef9f27;
}

.services {
    padding: 40px 32px 32px;
    background: var(--color-background-primary);
}

.section-label {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: #185fa5;
    margin-bottom: 6px;
}

.section-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 30px;
    font-weight: 700;
    color: var(--color-text-primary);
    margin-bottom: 24px;
    letter-spacing: -0.3px;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
}

.projects {
    padding: 32px;
    background: var(--color-background-tertiary);
}

.projects-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    margin-top: 20px;
}

.contact-bar {
    background: #042c53;
    padding: 24px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.contact-text {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 22px;
    font-weight: 700;
    color: #fff;
    letter-spacing: 0.2px;
}

.contact-sub {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.6);
    margin-top: 3px;
    font-weight: 300;
}

.contact-actions {
    display: flex;
    gap: 10px;
}

@media (max-width: 768px) {
    .services,
    .projects {
        padding: 28px 20px;
    }
    .services-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .projects-grid {
        grid-template-columns: 1fr;
    }
    .contact-bar {
        flex-direction: column;
        align-items: stretch;
        gap: 16px;
        padding: 20px;
        text-align: center;
    }
    .contact-actions {
        justify-content: center;
    }
    .ticker {
        padding: 10px 20px;
        gap: 20px;
    }
}

@media (max-width: 560px) {
    .services-grid {
        grid-template-columns: 1fr;
    }
    .section-title {
        font-size: 24px;
    }
    .contact-actions {
        flex-direction: column;
    }
}
</style>
