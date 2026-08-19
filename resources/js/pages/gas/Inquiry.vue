<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed, reactive, ref } from 'vue';
import GasFooter from '@/components/gas/GasFooter.vue';
import GasNavbar from '@/components/gas/GasNavbar.vue';
import { openWhatsApp } from '@/lib/whatsapp';

const props = defineProps<{
    settings: {
        whatsapp_number: string;
        pic1_name: string;
        pic1_phone: string;
        pic2_name: string;
        pic2_phone: string;
    };
}>();

const tabs = [
    { id: 0, label: 'Gas Pipeline', icon: 'ti-pipe' },
    { id: 1, label: 'CNG Station', icon: 'ti-gas-station' },
    { id: 2, label: 'Maintenance', icon: 'ti-tool' },
] as const;

const activeTab = ref<0 | 1 | 2>(0);
const copied = ref(false);

const pipeline = reactive({
    nama: '',
    jabatan: '',
    perusahaan: '',
    lokasi: '',
    panjang: '',
    tekanan: 'tekanan tinggi (> 4 bar)',
    waktu: '',
    info: '',
});
const cng = reactive({
    nama: '',
    jabatan: '',
    perusahaan: '',
    lokasi: '',
    jenis: 'SPBG Publik',
    kapasitas: '',
    peruntukan: 'armada truk / bus perusahaan',
    info: '',
});
const maintenance = reactive({
    nama: '',
    jabatan: '',
    perusahaan: '',
    lokasi: '',
    jenis: 'inspeksi rutin pipeline',
    aset: '',
    urgensi: 'rutin / terjadwal',
    info: '',
});

function greet(): string {
    const h = new Date().getHours();

    if (h < 12) {
        return 'pagi';
    }

    if (h < 15) {
        return 'siang';
    }

    if (h < 18) {
        return 'sore';
    }

    return 'malam';
}

const message = computed(() => {
    if (activeTab.value === 0) {
        const f = pipeline;
        const info = f.info ? `\n\n*Keterangan Tambahan:*\n${f.info}` : '';

        return `Halo, selamat ${greet()} 🙏\n\nPerkenalkan, saya *${f.nama || '[Nama Anda]'}*, ${f.jabatan || '[Jabatan]'} dari *${f.perusahaan || '[Nama Perusahaan]'}*.\n\nKami tertarik untuk mendapatkan informasi dan penawaran terkait jasa *konstruksi gas pipeline* dengan rincian sebagai berikut:\n\n📍 *Lokasi Proyek:* ${f.lokasi || '[Lokasi Proyek]'}\n📏 *Estimasi Panjang Pipa:* ${f.panjang || '[Panjang Pipa]'}\n⚙️ *Jenis/Tekanan Gas:* ${f.tekanan}\n📅 *Target Mulai:* ${f.waktu || '[Target Mulai]'}${info}\n\nMohon dapat diberikan informasi awal dan jadwal konsultasi teknis. Terima kasih.`;
    }

    if (activeTab.value === 1) {
        const f = cng;
        const info = f.info ? `\n\n*Info Tambahan:*\n${f.info}` : '';

        return `Halo, selamat ${greet()} 🙏\n\nSaya *${f.nama || '[Nama Anda]'}*, ${f.jabatan || '[Jabatan]'} dari *${f.perusahaan || '[Nama Perusahaan]'}*.\n\nKami berencana membangun fasilitas *CNG – ${f.jenis}* dan ingin mendapatkan penawaran dari Nusantara Gas Energy:\n\n📍 *Lokasi:* ${f.lokasi || '[Lokasi]'}\n🏭 *Jenis Fasilitas:* ${f.jenis}\n⚡ *Kapasitas:* ${f.kapasitas || '[Kapasitas]'} MMBtu/hari\n🚌 *Peruntukan:* ${f.peruntukan}${info}\n\nDapat dijadwalkan sesi konsultasi teknis? Terima kasih 🙏`;
    }

    const f = maintenance;
    const info = f.info ? `\n\n*Catatan:*\n${f.info}` : '';

    return `Halo, selamat ${greet()} 🙏\n\nSaya *${f.nama || '[Nama Anda]'}*, ${f.jabatan || '[Jabatan]'} dari *${f.perusahaan || '[Nama Perusahaan]'}*.\n\nKami membutuhkan jasa *maintenance & inspeksi gas* untuk fasilitas kami:\n\n📍 *Lokasi:* ${f.lokasi || '[Lokasi]'}\n🔧 *Jenis Pekerjaan:* ${f.jenis}\n📐 *Aset/Cakupan:* ${f.aset || '[Aset]'}\n⏱️ *Urgensi:* ${f.urgensi}${info}\n\nMohon info ketersediaan tim dan estimasi biaya. Terima kasih.`;
});

const waTime = computed(() => {
    const d = new Date();

    return `${d.getHours().toString().padStart(2, '0')}.${d.getMinutes().toString().padStart(2, '0')}`;
});

function copyText() {
    navigator.clipboard.writeText(message.value).then(() => {
        copied.value = true;
        setTimeout(() => (copied.value = false), 2500);
    });
}

function openWA() {
    openWhatsApp(message.value, props.settings.whatsapp_number);
}
</script>

<template>
    <Head title="Template Pesan WhatsApp — Nusantara Gas Energy" />

    <div class="nge pg">
        <GasNavbar active="inquiry" variant="topbar" />

        <div class="hero-strip">
            <div class="breadcrumb">
                Beranda &rsaquo; <span>Template Inquiry WhatsApp</span>
            </div>
            <div class="page-title">Template Pesan WhatsApp</div>
            <div class="page-sub">
                Isi data proyek Anda dan salin pesan siap kirim ke tim sales
                kami
            </div>
        </div>

        <div class="wrap">
            <div class="tab-row">
                <button
                    v-for="t in tabs"
                    :key="t.id"
                    class="tab"
                    :class="{ on: activeTab === t.id }"
                    @click="activeTab = t.id"
                >
                    <i
                        class="ti"
                        :class="t.icon"
                        style="font-size: 14px"
                        aria-hidden="true"
                    ></i>
                    {{ t.label }}
                </button>
            </div>

            <div class="cols">
                <div class="form-box">
                    <div class="form-title">
                        <i
                            class="ti ti-edit"
                            style="font-size: 16px; color: #378add"
                            aria-hidden="true"
                        ></i>
                        Isi data Anda
                    </div>

                    <div v-if="activeTab === 0">
                        <div class="fld">
                            <label>Nama Anda</label
                            ><input
                                v-model="pipeline.nama"
                                placeholder="Budi Santoso"
                            />
                        </div>
                        <div class="fld">
                            <label>Jabatan</label
                            ><input
                                v-model="pipeline.jabatan"
                                placeholder="Project Manager"
                            />
                        </div>
                        <div class="fld">
                            <label>Perusahaan</label
                            ><input
                                v-model="pipeline.perusahaan"
                                placeholder="PT. Maju Bersama"
                            />
                        </div>
                        <div class="fld">
                            <label>Lokasi Proyek</label
                            ><input
                                v-model="pipeline.lokasi"
                                placeholder="Karawang, Jawa Barat"
                            />
                        </div>
                        <div class="fld">
                            <label>Panjang Pipa (km)</label
                            ><input
                                v-model="pipeline.panjang"
                                placeholder="25 km"
                            />
                        </div>
                        <div class="fld">
                            <label>Jenis / Tekanan Gas</label>
                            <select v-model="pipeline.tekanan">
                                <option value="tekanan rendah (< 1 bar)">
                                    Tekanan rendah (&lt; 1 bar)
                                </option>
                                <option value="tekanan menengah (1–4 bar)">
                                    Tekanan menengah (1–4 bar)
                                </option>
                                <option value="tekanan tinggi (> 4 bar)">
                                    Tekanan tinggi (&gt; 4 bar)
                                </option>
                            </select>
                        </div>
                        <div class="fld">
                            <label>Target Waktu Mulai</label
                            ><input
                                v-model="pipeline.waktu"
                                placeholder="Q3 2025 / Bulan Juli 2025"
                            />
                        </div>
                        <div class="fld">
                            <label>Keterangan Tambahan</label
                            ><textarea
                                v-model="pipeline.info"
                                placeholder="Contoh: koneksi ke jaringan PGN, crossing jalan tol, dll."
                            ></textarea>
                        </div>
                    </div>

                    <div v-else-if="activeTab === 1">
                        <div class="fld">
                            <label>Nama Anda</label
                            ><input
                                v-model="cng.nama"
                                placeholder="Siti Rahayu"
                            />
                        </div>
                        <div class="fld">
                            <label>Jabatan</label
                            ><input
                                v-model="cng.jabatan"
                                placeholder="Direktur Operasional"
                            />
                        </div>
                        <div class="fld">
                            <label>Perusahaan</label
                            ><input
                                v-model="cng.perusahaan"
                                placeholder="PT. Trans Nusantara"
                            />
                        </div>
                        <div class="fld">
                            <label>Lokasi SPBG</label
                            ><input
                                v-model="cng.lokasi"
                                placeholder="Bekasi Barat, Jawa Barat"
                            />
                        </div>
                        <div class="fld">
                            <label>Jenis CNG</label>
                            <select v-model="cng.jenis">
                                <option>Mother Station</option>
                                <option>Daughter Station</option>
                                <option>SPBG Publik</option>
                                <option>Mobile Refueling Unit (MRU)</option>
                                <option>Virtual Pipeline</option>
                            </select>
                        </div>
                        <div class="fld">
                            <label>Kapasitas (MMBtu/hari)</label
                            ><input v-model="cng.kapasitas" placeholder="200" />
                        </div>
                        <div class="fld">
                            <label>Peruntukan</label>
                            <select v-model="cng.peruntukan">
                                <option value="kendaraan umum / angkutan kota">
                                    Kendaraan umum
                                </option>
                                <option value="armada truk / bus perusahaan">
                                    Armada truk / bus
                                </option>
                                <option value="industri / pabrik">
                                    Industri / pabrik
                                </option>
                                <option value="pembangkit listrik">
                                    Pembangkit listrik
                                </option>
                            </select>
                        </div>
                        <div class="fld">
                            <label>Keterangan Tambahan</label
                            ><textarea
                                v-model="cng.info"
                                placeholder="Contoh: lahan sudah tersedia, perlu kajian perizinan, dsb."
                            ></textarea>
                        </div>
                    </div>

                    <div v-else>
                        <div class="fld">
                            <label>Nama Anda</label
                            ><input
                                v-model="maintenance.nama"
                                placeholder="Agus Priyanto"
                            />
                        </div>
                        <div class="fld">
                            <label>Jabatan</label
                            ><input
                                v-model="maintenance.jabatan"
                                placeholder="Facility Manager"
                            />
                        </div>
                        <div class="fld">
                            <label>Perusahaan</label
                            ><input
                                v-model="maintenance.perusahaan"
                                placeholder="PT. Kilang Mandiri"
                            />
                        </div>
                        <div class="fld">
                            <label>Lokasi Fasilitas</label
                            ><input
                                v-model="maintenance.lokasi"
                                placeholder="Cilegon, Banten"
                            />
                        </div>
                        <div class="fld">
                            <label>Jenis Pekerjaan</label>
                            <select v-model="maintenance.jenis">
                                <option>inspeksi rutin pipeline</option>
                                <option>pigging & cleaning</option>
                                <option>cathodic protection</option>
                                <option>penggantian valve / fitting</option>
                                <option>leak test & commissioning</option>
                            </select>
                        </div>
                        <div class="fld">
                            <label>Panjang / Aset yang Dirawat</label
                            ><input
                                v-model="maintenance.aset"
                                placeholder="Contoh: 15 km, 3 unit compressor"
                            />
                        </div>
                        <div class="fld">
                            <label>Urgensi</label>
                            <select v-model="maintenance.urgensi">
                                <option>rutin / terjadwal</option>
                                <option>mendesak (dalam 1 minggu)</option>
                                <option>darurat / emergency</option>
                            </select>
                        </div>
                        <div class="fld">
                            <label>Keterangan Tambahan</label
                            ><textarea
                                v-model="maintenance.info"
                                placeholder="Kendala atau kondisi khusus yang perlu diketahui tim..."
                            ></textarea>
                        </div>
                    </div>
                </div>

                <div class="preview-box">
                    <div class="preview-title">
                        <i
                            class="ti ti-brand-whatsapp"
                            style="font-size: 16px; color: #3b6d11"
                            aria-hidden="true"
                        ></i>
                        Preview pesan WA
                    </div>
                    <div class="wa-bubble">
                        <div class="wa-text">{{ message }}</div>
                        <div class="wa-time">{{ waTime }}</div>
                    </div>
                    <div class="action-row">
                        <button class="btn-copy" @click="copyText">
                            <i
                                class="ti ti-copy"
                                style="font-size: 15px"
                                aria-hidden="true"
                            ></i>
                            Salin pesan
                        </button>
                        <button class="btn-wa" @click="openWA">
                            <i
                                class="ti ti-brand-whatsapp"
                                style="font-size: 15px"
                                aria-hidden="true"
                            ></i>
                            Buka WA
                        </button>
                    </div>
                    <div class="copied" :class="{ show: copied }">
                        <i
                            class="ti ti-circle-check"
                            style="font-size: 15px"
                            aria-hidden="true"
                        ></i>
                        Pesan berhasil disalin!
                    </div>
                    <div class="tip">
                        <i
                            class="ti ti-info-circle"
                            style="font-size: 14px; vertical-align: -2px"
                            aria-hidden="true"
                        ></i>
                        Kirim ke <strong>{{ settings.pic1_phone }}</strong> ({{
                            settings.pic1_name
                        }}) atau <strong>{{ settings.pic2_phone }}</strong> ({{
                            settings.pic2_name
                        }}).
                    </div>
                </div>
            </div>
        </div>

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
    padding: 28px 28px 24px;
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
}

.wrap {
    padding: 24px 28px;
}
.tab-row {
    display: flex;
    gap: 8px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.tab {
    padding: 7px 14px;
    border-radius: 6px;
    border: 0.5px solid var(--color-border-secondary);
    background: var(--color-background-secondary);
    font-size: 12.5px;
    font-weight: 500;
    cursor: pointer;
    color: var(--color-text-secondary);
    transition: all 0.15s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.tab.on {
    background: #e6f1fb;
    border-color: #85b7eb;
    color: #0c447c;
}
.cols {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
    gap: 16px;
}
.form-box {
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: var(--border-radius-lg);
    padding: 18px;
}
.form-title {
    font-size: 13px;
    font-weight: 500;
    color: var(--color-text-primary);
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 7px;
}
.fld {
    margin-bottom: 11px;
}
.fld label {
    display: block;
    font-size: 11px;
    font-weight: 500;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    color: var(--color-text-secondary);
    margin-bottom: 4px;
}
.fld input,
.fld select,
.fld textarea {
    width: 100%;
    font-family: 'Barlow', sans-serif;
    font-size: 13px;
    padding: 8px 10px;
    border: 0.5px solid var(--color-border-secondary);
    border-radius: 6px;
    background: var(--color-background-secondary);
    color: var(--color-text-primary);
    outline: none;
}
.fld input:focus,
.fld select:focus,
.fld textarea:focus {
    border-color: #378add;
}
.fld textarea {
    resize: vertical;
    min-height: 68px;
}
.preview-box {
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: var(--border-radius-lg);
    padding: 18px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.preview-title {
    font-size: 13px;
    font-weight: 500;
    color: var(--color-text-primary);
    display: flex;
    align-items: center;
    gap: 7px;
}
.wa-bubble {
    background: #eaf3de;
    border-radius: 10px;
    border-bottom-left-radius: 2px;
    padding: 12px 14px;
    border: 0.5px solid #97c459;
}
.wa-text {
    font-size: 12.5px;
    color: #27500a;
    line-height: 1.65;
    white-space: pre-wrap;
    word-break: break-word;
}
.wa-time {
    font-size: 10.5px;
    color: #639922;
    text-align: right;
    margin-top: 6px;
}
.action-row {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}
.btn-copy {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 6px;
    background: #27500a;
    color: #eaf3de;
    font-family: 'Barlow', sans-serif;
    font-size: 12.5px;
    font-weight: 500;
    border: none;
    cursor: pointer;
}
.btn-wa {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 6px;
    background: #eaf3de;
    color: #27500a;
    font-family: 'Barlow', sans-serif;
    font-size: 12.5px;
    font-weight: 500;
    border: 0.5px solid #97c459;
    cursor: pointer;
}
.copied {
    font-size: 11.5px;
    color: var(--color-text-success);
    display: none;
    align-items: center;
    gap: 4px;
    padding: 8px 0;
}
.copied.show {
    display: flex;
}
.tip {
    font-size: 11.5px;
    color: var(--color-text-secondary);
    line-height: 1.5;
    background: var(--color-background-secondary);
    padding: 9px 12px;
    border-left: 3px solid #378add;
    border-radius: 0 6px 6px 0;
}

@media (max-width: 900px) {
    .cols {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 640px) {
    .hero-strip {
        padding: 22px 20px 18px;
    }
    .page-title {
        font-size: 28px;
    }
    .wrap {
        padding: 20px;
    }
    .action-row {
        flex-direction: column;
    }
    .action-row button {
        justify-content: center;
    }
}
</style>
