<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import GasBtnPrimary from '@/components/gas/GasBtnPrimary.vue';
import GasBtnWa from '@/components/gas/GasBtnWa.vue';
import GasCertCard from '@/components/gas/GasCertCard.vue';
import GasCtaStrip from '@/components/gas/GasCtaStrip.vue';
import GasFooter from '@/components/gas/GasFooter.vue';
import GasHero from '@/components/gas/GasHero.vue';
import GasNavbar from '@/components/gas/GasNavbar.vue';
import { openWhatsApp } from '@/lib/whatsapp';
import { contact } from '@/routes';

defineProps<{
    certifications: {
        icon: string;
        icon_bg: string;
        icon_color: string;
        name: string;
        issuer: string;
        valid_text: string;
    }[];
    settings: {
        whatsapp_number: string;
    };
}>();
</script>

<template>
    <Head title="Sertifikasi & Izin — Nusantara Gas Energy" />

    <div class="nge pg">
        <GasHero
            badge="Sertifikasi & Izin"
            description="Seluruh proyek kami dikerjakan sesuai standar keselamatan dan regulasi yang berlaku, didukung sertifikasi dan izin resmi dari lembaga terkait."
        >
            <template #navbar>
                <GasNavbar active="certifications" variant="hero" />
            </template>
            <template #title>
                Sertifikasi & Izin<br /><span>Resmi & Terverifikasi</span>
            </template>
        </GasHero>

        <div class="section">
            <div class="cert-grid">
                <GasCertCard
                    v-for="c in certifications"
                    :key="c.name"
                    :icon="c.icon"
                    :icon-bg="c.icon_bg"
                    :icon-color="c.icon_color"
                    :name="c.name"
                    :issuer="c.issuer"
                    :valid="c.valid_text"
                />
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

.section {
    padding: 24px 28px;
}

.cert-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
}

@media (max-width: 768px) {
    .section {
        padding: 20px;
    }
    .cert-grid {
        grid-template-columns: 1fr;
    }
}
</style>
