<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import GasBtnOutline from '@/components/gas/GasBtnOutline.vue';
import GasBtnPrimary from '@/components/gas/GasBtnPrimary.vue';
import GasCtaStrip from '@/components/gas/GasCtaStrip.vue';
import GasFooter from '@/components/gas/GasFooter.vue';
import GasHeroStrip from '@/components/gas/GasHeroStrip.vue';
import GasNavbar from '@/components/gas/GasNavbar.vue';
import GasPortfolioCard from '@/components/gas/GasPortfolioCard.vue';
import type { PortfolioProject } from '@/components/gas/GasPortfolioCard.vue';
import GasPortfolioDetailModal from '@/components/gas/GasPortfolioDetailModal.vue';
import GasStatBox from '@/components/gas/GasStatBox.vue';
import { openWhatsApp } from '@/lib/whatsapp';
import { contact } from '@/routes';

const props = defineProps<{
    projects: PortfolioProject[];
    stats: {
        totalProjects: string;
        pipelineKm: string;
        activeClients: string;
        provinces: string;
    };
}>();

const filters = [
    { id: 'all', label: 'Semua' },
    { id: 'pipeline', label: 'Gas Pipeline' },
    { id: 'cng', label: 'CNG Station' },
    { id: 'maintenance', label: 'Maintenance' },
    { id: 'engineering', label: 'Engineering' },
];

const activeFilter = ref('all');
const activeSort = ref<'year' | 'name' | 'scale'>('year');
const selectedId = ref<number | null>(null);

const page = usePage<{ siteSettings: { whatsapp_number: string } }>();

const selectedProject = computed(
    () => props.projects.find((p) => p.id === selectedId.value) ?? null,
);

const visibleProjects = computed(() => {
    const list = props.projects.filter(
        (p) => activeFilter.value === 'all' || p.cat === activeFilter.value,
    );
    const sorted = [...list];

    if (activeSort.value === 'year') {
        sorted.sort((a, b) => b.year - a.year);
    } else if (activeSort.value === 'name') {
        sorted.sort((a, b) => a.name.localeCompare(b.name));
    } else {
        sorted.sort((a, b) => b.scale - a.scale);
    }

    return sorted;
});

function closeDetail() {
    selectedId.value = null;
}

function inquiryFromDetail() {
    if (selectedProject.value) {
        openWhatsApp(
            `Saya tertarik dengan proyek serupa: ${selectedProject.value.name}. Bisa minta penawaran untuk proyek sejenis?`,
            page.props.siteSettings.whatsapp_number,
        );
    }

    closeDetail();
}
</script>

<template>
    <Head title="Portofolio Proyek — Nusantara Gas Energy" />

    <div class="nge pg">
        <GasNavbar active="portfolio" variant="topbar" />

        <GasHeroStrip
            crumb="Portofolio Proyek"
            title="Portofolio Proyek"
            subtitle="Rekam jejak lebih dari 200 proyek gas bumi yang telah diselesaikan di seluruh Indonesia sejak 2008."
        >
            <template #stats>
                <GasStatBox :num="stats.totalProjects" label="Total Proyek" />
                <GasStatBox :num="stats.pipelineKm" label="Pipeline" />
                <GasStatBox :num="stats.activeClients" label="Klien Aktif" />
                <GasStatBox :num="stats.provinces" label="Provinsi" />
            </template>
        </GasHeroStrip>

        <div class="toolbar">
            <div class="filter-row">
                <button
                    v-for="f in filters"
                    :key="f.id"
                    class="ftag"
                    :class="{ on: activeFilter === f.id }"
                    @click="activeFilter = f.id"
                >
                    {{ f.label }}
                </button>
            </div>
            <div class="sort-row">
                <span class="sort-label">Urutkan:</span>
                <select v-model="activeSort" class="sort-sel">
                    <option value="year">Terbaru</option>
                    <option value="name">Nama A–Z</option>
                    <option value="scale">Skala Terbesar</option>
                </select>
            </div>
        </div>

        <div class="grid-area">
            <GasPortfolioCard
                v-for="p in visibleProjects"
                :key="p.id"
                :project="p"
                @open="selectedId = $event"
            />
            <div v-if="!visibleProjects.length" class="empty-state">
                Tidak ada proyek ditemukan.
            </div>
        </div>

        <GasPortfolioDetailModal
            :project="selectedProject"
            @close="closeDetail"
            @inquiry="inquiryFromDetail"
        />

        <GasCtaStrip
            text="Proyek Anda bisa menjadi yang berikutnya"
            sub="Konsultasi teknis gratis — respons dalam 24 jam kerja"
        >
            <GasBtnOutline
                icon="ti-brand-whatsapp"
                @click="
                    openWhatsApp(
                        'Buatkan template pesan WhatsApp untuk inquiry proyek gas pipeline dan CNG ke tim sales',
                        page.props.siteSettings.whatsapp_number,
                    )
                "
                >Chat WA</GasBtnOutline
            >
            <GasBtnPrimary
                icon="ti-file-description"
                @click="router.visit(contact())"
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

.toolbar {
    background: var(--color-background-primary);
    padding: 12px 28px;
    border-bottom: 0.5px solid var(--color-border-tertiary);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
}
.filter-row {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}
.ftag {
    padding: 5px 13px;
    border-radius: 20px;
    border: 0.5px solid var(--color-border-secondary);
    background: transparent;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    color: var(--color-text-secondary);
    font-family: 'Barlow', sans-serif;
    transition: all 0.15s;
}
.ftag.on {
    background: #042c53;
    border-color: #042c53;
    color: #fff;
}
.sort-row {
    display: flex;
    align-items: center;
    gap: 8px;
}
.sort-label {
    font-size: 12px;
    color: var(--color-text-tertiary);
}
.sort-sel {
    font-family: 'Barlow', sans-serif;
    font-size: 12.5px;
    padding: 5px 10px;
    border-radius: 6px;
    border: 0.5px solid var(--color-border-secondary);
    background: var(--color-background-secondary);
    color: var(--color-text-primary);
}

.grid-area {
    padding: 20px 28px;
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
}
.empty-state {
    grid-column: 1 / -1;
    padding: 40px;
    text-align: center;
    color: var(--color-text-tertiary);
    font-size: 14px;
}

@media (max-width: 640px) {
    .toolbar {
        padding: 12px 20px;
    }
    .grid-area {
        padding: 16px 20px;
        grid-template-columns: 1fr;
    }
    .sort-row {
        width: 100%;
        justify-content: space-between;
    }
}
</style>
