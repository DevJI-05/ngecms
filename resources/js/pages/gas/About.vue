<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import GasBtnPrimary from '@/components/gas/GasBtnPrimary.vue';
import GasBtnWa from '@/components/gas/GasBtnWa.vue';
import GasCertCard from '@/components/gas/GasCertCard.vue';
import GasCtaStrip from '@/components/gas/GasCtaStrip.vue';
import GasFooter from '@/components/gas/GasFooter.vue';
import GasHeroStrip from '@/components/gas/GasHeroStrip.vue';
import GasNavbar from '@/components/gas/GasNavbar.vue';
import GasStatBox from '@/components/gas/GasStatBox.vue';
import GasTimelineItem from '@/components/gas/GasTimelineItem.vue';
import GasValueCard from '@/components/gas/GasValueCard.vue';
import { openWhatsApp } from '@/lib/whatsapp';
import { contact } from '@/routes';

interface TeamMember {
    id: number;
    parent_id: number | null;
    name: string;
    role: string;
    level: 'komisaris' | 'direksi' | 'manajer' | 'staff';
    initials: string;
    avatar_bg: string;
    avatar_color: string;
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
    certifications: {
        icon: string;
        icon_bg: string;
        icon_color: string;
        name: string;
        issuer: string;
        valid_text: string;
    }[];
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
    { id: 'cert', label: 'Sertifikasi & Izin' },
];
const activeTab = ref('profil');

const komisaris = computed(() =>
    props.teamMembers.find((m) => m.level === 'komisaris'),
);
const direksiUtama = computed(() =>
    props.teamMembers.find((m) => m.level === 'direksi'),
);
const directors = computed(() =>
    props.teamMembers
        .filter((m) => m.level === 'manajer')
        .map((director) => ({
            ...director,
            depts: props.teamMembers.filter((m) => m.parent_id === director.id),
        })),
);
</script>

<template>
    <Head title="Tentang Kami — Nusantara Gas Energy" />

    <div class="nge pg">
        <GasNavbar active="about" variant="topbar" />

        <GasHeroStrip
            crumb="Tentang Kami"
            title="Tentang Kami"
            subtitle="Lebih dari 15 tahun membangun infrastruktur gas bumi Indonesia — dari Jawa, Sumatera, hingga Kalimantan. Bersertifikat, berpengalaman, dan berkomitmen pada keselamatan."
            subtitle-width="440px"
        >
            <template #stats>
                <GasStatBox
                    :num="String(settings.established_year)"
                    label="Berdiri"
                />
                <GasStatBox
                    :num="stats.projectsCompleted"
                    label="Proyek"
                />
                <GasStatBox :num="stats.employees" label="Karyawan" />
                <GasStatBox :num="stats.provinces" label="Provinsi" />
            </template>
        </GasHeroStrip>

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
            <div class="org-wrap">
                <div
                    v-if="komisaris"
                    style="text-align: center; margin-bottom: 4px"
                >
                    <div class="org-group-label">Dewan Komisaris</div>
                    <div class="org-card top" style="margin: 0 auto">
                        <div
                            class="org-avatar"
                            :style="{
                                background: komisaris.avatar_bg,
                                color: komisaris.avatar_color,
                            }"
                        >
                            {{ komisaris.initials }}
                        </div>
                        <div class="org-name">{{ komisaris.name }}</div>
                        <div class="org-role">{{ komisaris.role }}</div>
                    </div>
                </div>
                <div v-if="komisaris && direksiUtama" class="org-line-v"></div>
                <div
                    v-if="direksiUtama"
                    style="text-align: center; margin-bottom: 4px"
                >
                    <div class="org-group-label">Direksi</div>
                    <div class="org-card top" style="margin: 0 auto">
                        <div
                            class="org-avatar"
                            :style="{
                                background: direksiUtama.avatar_bg,
                                color: direksiUtama.avatar_color,
                            }"
                        >
                            {{ direksiUtama.initials }}
                        </div>
                        <div class="org-name">{{ direksiUtama.name }}</div>
                        <div class="org-role">{{ direksiUtama.role }}</div>
                    </div>
                </div>
                <div v-if="direksiUtama" class="org-line-v"></div>
                <div class="org-directors-row">
                    <div
                        v-for="d in directors"
                        :key="d.id"
                        style="
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                        "
                    >
                        <div class="org-card mid">
                            <div
                                class="org-avatar"
                                :style="{
                                    background: d.avatar_bg,
                                    color: d.avatar_color,
                                }"
                            >
                                {{ d.initials }}
                            </div>
                            <div class="org-name">{{ d.name }}</div>
                            <div class="org-role">{{ d.role }}</div>
                        </div>
                        <div v-if="d.depts.length" class="org-line-v"></div>
                        <div style="display: flex; gap: 10px">
                            <div
                                v-for="dept in d.depts"
                                :key="dept.id"
                                class="org-card dir"
                                :style="{
                                    minWidth: '120px',
                                    maxWidth: '130px',
                                    borderTopColor: dept.avatar_color,
                                }"
                            >
                                <div
                                    class="org-avatar"
                                    :style="{
                                        width: '30px',
                                        height: '30px',
                                        fontSize: '11px',
                                        background: dept.avatar_bg,
                                        color: dept.avatar_color,
                                    }"
                                >
                                    {{ dept.initials }}
                                </div>
                                <div class="org-name" style="font-size: 11.5px">
                                    {{ dept.name }}
                                </div>
                                <div class="org-role">{{ dept.role }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SERTIFIKASI -->
        <div v-show="activeTab === 'cert'" class="section">
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

.org-group-label {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--color-text-tertiary);
    margin-bottom: 6px;
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
.org-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0;
}
.org-card {
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: var(--border-radius-lg);
    padding: 12px 16px;
    text-align: center;
    min-width: 140px;
    max-width: 160px;
}
.org-card.top {
    border-top: 3px solid #185fa5;
    min-width: 180px;
}
.org-card.mid {
    border-top: 3px solid #ef9f27;
}
.org-card.dir {
    border-top: 3px solid #3b6d11;
}
.org-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 14px;
    margin: 0 auto 8px;
}
.org-name {
    font-weight: 500;
    font-size: 13px;
    color: var(--color-text-primary);
    line-height: 1.2;
}
.org-role {
    font-size: 10.5px;
    color: var(--color-text-tertiary);
    margin-top: 3px;
    line-height: 1.3;
}
.org-line-v {
    width: 2px;
    height: 18px;
    background: var(--color-border-secondary);
    margin: 0 auto;
}

/* SERTIFIKASI */
.cert-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
}

.org-directors-row {
    display: flex;
    gap: 14px;
    justify-content: center;
    margin-bottom: 4px;
    flex-wrap: wrap;
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
    .cert-grid {
        grid-template-columns: 1fr;
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
    .org-card {
        min-width: 120px;
        max-width: 140px;
    }
    .org-card.top {
        min-width: 150px;
    }
}
</style>
