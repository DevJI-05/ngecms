<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { store } from '@/actions/App/Http/Controllers/Gas/ContactController';
import GasFooter from '@/components/gas/GasFooter.vue';
import GasNavbar from '@/components/gas/GasNavbar.vue';
import { openWhatsApp } from '@/lib/whatsapp';

const props = defineProps<{
    settings: {
        address: string;
        phone: string;
        fax: string | null;
        email_info: string;
        email_project: string | null;
        hours_weekday: string;
        hours_saturday: string;
        hours_sunday: string;
        emergency_phone: string;
        pic1_name: string;
        pic1_role: string;
        pic1_phone: string;
        pic2_name: string;
        pic2_role: string;
        pic2_phone: string;
        map_query: string | null;
    };
}>();

const page = usePage<{
    flash: { inquirySubmitted?: { nama: string; ref: string } };
}>();
const submitted = computed(() => page.props.flash?.inquirySubmitted);

const form = useForm({
    nama: '',
    jabatan: '',
    email: '',
    telepon: '',
    perusahaan: '',
    layanan: '',
    estimasi: '',
    lokasi: '',
    pesan: '',
    sumber: '',
});

function submitInquiry() {
    form.post(store.url(), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}

function chatWhatsApp() {
    openWhatsApp(
        'Buatkan template pesan WhatsApp untuk inquiry proyek gas pipeline dan CNG ke tim sales',
    );
}

function openMap() {
    const query = encodeURIComponent(
        props.settings.map_query ?? props.settings.address,
    );
    window.open(
        `https://maps.google.com/?q=${query}`,
        '_blank',
        'noopener,noreferrer',
    );
}
</script>

<template>
    <Head title="Hubungi Kami — Nusantara Gas Energy" />

    <div class="nge pg">
        <GasNavbar active="contact" variant="topbar" />

        <div class="hero-strip">
            <div class="breadcrumb">
                Beranda &rsaquo; <span>Hubungi Kami</span>
            </div>
            <div class="page-title">Hubungi Kami</div>
            <div class="page-sub">
                Tim kami siap merespons inquiry Anda dalam 1&times;24 jam kerja
            </div>
        </div>

        <div class="body-wrap">
            <div class="form-panel">
                <div class="panel-heading">
                    Kirim Pesan &amp; Inquiry Proyek
                </div>
                <div class="panel-sub">
                    Isi form di bawah untuk konsultasi teknis, penawaran proyek,
                    atau pertanyaan umum seputar layanan gas pipeline dan CNG
                    kami.
                </div>

                <div class="field-row">
                    <div class="field">
                        <label
                            >Nama Lengkap
                            <span class="req-badge">Wajib</span></label
                        >
                        <input
                            v-model="form.nama"
                            type="text"
                            placeholder="Budi Santoso"
                        />
                    </div>
                    <div class="field">
                        <label>Jabatan</label>
                        <input
                            v-model="form.jabatan"
                            type="text"
                            placeholder="Project Manager"
                        />
                    </div>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label
                            >Email <span class="req-badge">Wajib</span></label
                        >
                        <input
                            v-model="form.email"
                            type="email"
                            placeholder="email@perusahaan.com"
                        />
                    </div>
                    <div class="field">
                        <label>No. Telepon / WhatsApp</label>
                        <input
                            v-model="form.telepon"
                            type="tel"
                            placeholder="+62 812 xxxx xxxx"
                        />
                    </div>
                </div>

                <div class="field">
                    <label>Nama Perusahaan</label>
                    <input
                        v-model="form.perusahaan"
                        type="text"
                        placeholder="PT. Contoh Industri"
                    />
                </div>

                <div class="field-row">
                    <div class="field">
                        <label
                            >Jenis Layanan
                            <span class="req-badge">Wajib</span></label
                        >
                        <select v-model="form.layanan">
                            <option value="">-- Pilih layanan --</option>
                            <option>Gas Pipeline Construction</option>
                            <option>CNG Station &amp; Distribution</option>
                            <option>Maintenance &amp; Inspection</option>
                            <option>Engineering &amp; Consulting</option>
                            <option>Emergency Response</option>
                            <option>Lainnya</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Estimasi Nilai Proyek</label>
                        <select v-model="form.estimasi">
                            <option value="">-- Pilih rentang --</option>
                            <option>&lt; Rp 1 Miliar</option>
                            <option>Rp 1 – 5 Miliar</option>
                            <option>Rp 5 – 20 Miliar</option>
                            <option>Rp 20 – 100 Miliar</option>
                            <option>&gt; Rp 100 Miliar</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label>Lokasi Proyek</label>
                    <input
                        v-model="form.lokasi"
                        type="text"
                        placeholder="Contoh: Kawasan Industri Karawang, Jawa Barat"
                    />
                </div>

                <div class="field">
                    <label
                        >Detail Pesan / Kebutuhan Teknis
                        <span class="req-badge">Wajib</span></label
                    >
                    <textarea
                        v-model="form.pesan"
                        placeholder="Jelaskan kebutuhan proyek Anda — panjang pipa, tekanan gas, kapasitas CNG, timeline, atau pertanyaan teknis lainnya..."
                    ></textarea>
                </div>

                <div class="field">
                    <label>Dari mana Anda mengetahui kami?</label>
                    <select v-model="form.sumber">
                        <option value="">-- Pilih --</option>
                        <option>Google / Search Engine</option>
                        <option>Referensi / Rekomendasi</option>
                        <option>LinkedIn</option>
                        <option>Pameran / Event Industri</option>
                        <option>Rekanan / Mitra Bisnis</option>
                        <option>Lainnya</option>
                    </select>
                </div>

                <div class="submit-row">
                    <button
                        class="btn-send"
                        :disabled="form.processing"
                        :style="{ opacity: form.processing ? 0.5 : 1 }"
                        @click="submitInquiry"
                    >
                        <i class="ti ti-send" aria-hidden="true"></i> Kirim
                        Inquiry
                    </button>
                    <button class="btn-wa" @click="chatWhatsApp">
                        <i class="ti ti-brand-whatsapp" aria-hidden="true"></i>
                        Chat WhatsApp
                    </button>
                </div>
                <div class="form-note">
                    Dengan mengirimkan form ini, Anda menyetujui bahwa data Anda
                    akan digunakan untuk keperluan tindak lanjut inquiry. Kami
                    tidak akan membagikan data Anda kepada pihak ketiga.
                </div>

                <div class="success-box" :class="{ show: submitted }">
                    <i
                        class="ti ti-circle-check"
                        style="
                            color: #3b6d11;
                            font-size: 22px;
                            flex-shrink: 0;
                            margin-top: 1px;
                        "
                        aria-hidden="true"
                    ></i>
                    <div v-if="submitted">
                        <div class="success-title">
                            Inquiry berhasil dikirim!
                        </div>
                        <div class="success-desc">
                            Terima kasih, <strong>{{ submitted.nama }}</strong
                            >. Tim kami akan menghubungi Anda melalui email atau
                            WhatsApp dalam 1&times;24 jam kerja. Nomor referensi
                            inquiry Anda: <strong>{{ submitted.ref }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-panel">
                <div class="info-section">
                    <div class="info-label">Kantor Pusat</div>
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="ti ti-map-pin" aria-hidden="true"></i>
                        </div>
                        <div class="info-text">
                            <strong>Alamat</strong>{{ settings.address }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="ti ti-phone" aria-hidden="true"></i>
                        </div>
                        <div class="info-text">
                            <strong>Telepon</strong>{{ settings.phone
                            }}<template v-if="settings.fax"
                                ><br />{{ settings.fax }} (Fax)</template
                            >
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="ti ti-mail" aria-hidden="true"></i>
                        </div>
                        <div class="info-text">
                            <strong>Email</strong>{{ settings.email_info
                            }}<template v-if="settings.email_project"
                                ><br />{{ settings.email_project }}</template
                            >
                        </div>
                    </div>
                </div>

                <hr class="divider" />

                <div class="info-section">
                    <div class="info-label">Person in Charge</div>
                    <div class="person-card">
                        <div class="person-avatar">
                            {{ settings.pic1_name.slice(0, 2).toUpperCase() }}
                        </div>
                        <div>
                            <div class="person-name">
                                {{ settings.pic1_name }}
                            </div>
                            <div class="person-role">
                                {{ settings.pic1_role }}
                            </div>
                            <div class="person-phone">
                                {{ settings.pic1_phone }}
                            </div>
                        </div>
                    </div>
                    <div class="person-card">
                        <div
                            class="person-avatar"
                            style="background: #0f6e56; color: #9fe1cb"
                        >
                            {{ settings.pic2_name.slice(0, 2).toUpperCase() }}
                        </div>
                        <div>
                            <div class="person-name">
                                {{ settings.pic2_name }}
                            </div>
                            <div class="person-role">
                                {{ settings.pic2_role }}
                            </div>
                            <div class="person-phone">
                                {{ settings.pic2_phone }}
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="divider" />

                <div class="info-section">
                    <div class="info-label">Jam Operasional</div>
                    <div class="hours-row active">
                        <span class="hours-day"
                            ><i
                                class="ti ti-circle-filled"
                                style="font-size: 8px; margin-right: 4px"
                                aria-hidden="true"
                            ></i
                            >Senin – Jumat</span
                        >
                        <span class="hours-time">{{
                            settings.hours_weekday
                        }}</span>
                    </div>
                    <div class="hours-row">
                        <span class="hours-day">Sabtu</span>
                        <span class="hours-time">{{
                            settings.hours_saturday
                        }}</span>
                    </div>
                    <div class="hours-row">
                        <span class="hours-day">Minggu &amp; Libur</span>
                        <span class="hours-time">{{
                            settings.hours_sunday
                        }}</span>
                    </div>
                    <div
                        style="
                            margin-top: 10px;
                            display: flex;
                            align-items: center;
                            gap: 8px;
                            background: rgba(239, 159, 39, 0.12);
                            border-radius: 6px;
                            padding: 9px 12px;
                            border: 0.5px solid rgba(239, 159, 39, 0.3);
                        "
                    >
                        <i
                            class="ti ti-emergency-bed"
                            style="color: #ef9f27; font-size: 18px"
                            aria-hidden="true"
                        ></i>
                        <div>
                            <div
                                style="
                                    font-size: 11.5px;
                                    font-weight: 500;
                                    color: #ef9f27;
                                "
                            >
                                Emergency 24/7
                            </div>
                            <div
                                style="
                                    font-size: 11px;
                                    color: rgba(255, 255, 255, 0.6);
                                "
                            >
                                {{ settings.emergency_phone }} (Gratis)
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="divider" />

                <div class="info-section">
                    <div class="info-label">Lokasi di Peta</div>
                    <div class="map-placeholder" @click="openMap">
                        <i
                            class="ti ti-map-2"
                            style="
                                color: rgba(255, 255, 255, 0.4);
                                font-size: 24px;
                            "
                            aria-hidden="true"
                        ></i>
                        <div class="map-label">Menara Gas, TB Simatupang</div>
                        <div class="map-link">Buka di Google Maps &rarr;</div>
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
    margin-top: 5px;
    font-weight: 300;
}

.body-wrap {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 300px);
    gap: 0;
}

.form-panel {
    background: var(--color-background-primary);
    padding: 28px;
}
.panel-heading {
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 20px;
    color: var(--color-text-primary);
    margin-bottom: 4px;
    letter-spacing: 0.2px;
}
.panel-sub {
    font-size: 12.5px;
    color: var(--color-text-secondary);
    margin-bottom: 20px;
    line-height: 1.5;
}

.field-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 12px;
}
.field {
    margin-bottom: 12px;
}
.field label {
    display: block;
    font-size: 11.5px;
    font-weight: 500;
    color: var(--color-text-secondary);
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-bottom: 5px;
}
.field input,
.field select,
.field textarea {
    width: 100%;
    font-family: 'Barlow', sans-serif;
    font-size: 13.5px;
    padding: 9px 12px;
    border: 0.5px solid var(--color-border-secondary);
    border-radius: 6px;
    background: var(--color-background-secondary);
    color: var(--color-text-primary);
    outline: none;
}
.field input:focus,
.field select:focus,
.field textarea:focus {
    border-color: #185fa5;
    box-shadow: 0 0 0 2px rgba(24, 95, 165, 0.15);
}
.field textarea {
    resize: vertical;
    min-height: 90px;
}

.req-badge {
    display: inline-block;
    font-size: 9px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    background: #e6f1fb;
    color: #0c447c;
    padding: 2px 7px;
    border-radius: 3px;
    margin-left: 6px;
    vertical-align: middle;
}

.submit-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 18px;
}
.btn-send {
    background: #185fa5;
    color: #fff;
    font-family: 'Barlow', sans-serif;
    font-weight: 600;
    font-size: 13px;
    padding: 10px 22px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 7px;
    letter-spacing: 0.3px;
}
.btn-send:active {
    opacity: 0.9;
}
.btn-wa {
    background: #eaf3de;
    color: #27500a;
    font-family: 'Barlow', sans-serif;
    font-weight: 500;
    font-size: 13px;
    padding: 10px 18px;
    border: 0.5px solid #97c459;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 7px;
}
.form-note {
    font-size: 11px;
    color: var(--color-text-tertiary);
    margin-top: 10px;
    line-height: 1.5;
}

.success-box {
    display: none;
    background: #eaf3de;
    border: 0.5px solid #97c459;
    border-radius: 8px;
    padding: 16px 20px;
    margin-top: 14px;
    align-items: flex-start;
    gap: 12px;
}
.success-box.show {
    display: flex;
}
.success-title {
    font-weight: 500;
    font-size: 14px;
    color: #27500a;
    margin-bottom: 3px;
}
.success-desc {
    font-size: 12.5px;
    color: #3b6d11;
    line-height: 1.5;
}

.info-panel {
    background: #042c53;
    padding: 28px;
}
.info-section {
    margin-bottom: 24px;
}
.info-label {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.45);
    margin-bottom: 10px;
}
.info-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 12px;
}
.info-icon {
    width: 32px;
    height: 32px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #ef9f27;
    font-size: 16px;
}
.info-text {
    font-size: 12.5px;
    color: rgba(255, 255, 255, 0.75);
    line-height: 1.55;
}
.info-text :deep(strong) {
    color: #fff;
    font-weight: 500;
    display: block;
    font-size: 13px;
    margin-bottom: 1px;
}

.divider {
    border: none;
    border-top: 0.5px solid rgba(255, 255, 255, 0.1);
    margin: 20px 0;
}

.person-card {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}
.person-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #185fa5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 13px;
    color: #b5d4f4;
    flex-shrink: 0;
}
.person-name {
    font-size: 13px;
    font-weight: 500;
    color: #fff;
}
.person-role {
    font-size: 11px;
    color: rgba(255, 255, 255, 0.5);
}
.person-phone {
    font-size: 12px;
    color: #ef9f27;
    margin-top: 2px;
}

.hours-row {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    padding: 5px 0;
    border-bottom: 0.5px solid rgba(255, 255, 255, 0.07);
}
.hours-day {
    color: rgba(255, 255, 255, 0.65);
}
.hours-time {
    color: #fff;
    font-weight: 500;
}
.hours-row.active .hours-day {
    color: #ef9f27;
}
.hours-row.active .hours-time {
    color: #ef9f27;
}

.map-placeholder {
    background: rgba(255, 255, 255, 0.06);
    border: 0.5px solid rgba(255, 255, 255, 0.12);
    border-radius: 8px;
    height: 100px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    cursor: pointer;
    margin-top: 4px;
}
.map-placeholder:hover {
    background: rgba(255, 255, 255, 0.09);
}
.map-label {
    font-size: 11.5px;
    color: rgba(255, 255, 255, 0.55);
}
.map-link {
    font-size: 11px;
    color: #ef9f27;
    text-decoration: none;
    font-weight: 500;
}

@media (max-width: 900px) {
    .body-wrap {
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
    .form-panel,
    .info-panel {
        padding: 20px;
    }
    .field-row {
        grid-template-columns: 1fr;
        gap: 0;
    }
    .submit-row {
        flex-direction: column;
        align-items: stretch;
    }
    .submit-row button {
        justify-content: center;
    }
}
</style>
