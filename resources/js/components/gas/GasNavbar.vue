<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { about, contact, home, portfolio, services } from '@/routes';

defineProps<{
    active: 'home' | 'services' | 'portfolio' | 'about' | 'contact' | 'inquiry';
    variant?: 'hero' | 'topbar';
}>();

const page = usePage<{
    siteSettings: { company_name: string; tagline: string };
}>();
const companyName = computed(() =>
    page.props.siteSettings.company_name.toUpperCase(),
);
const tagline = computed(() => page.props.siteSettings.tagline);

const mobileOpen = ref(false);
</script>

<template>
    <nav :class="variant === 'topbar' ? 'topbar' : 'navbar'">
        <div :class="variant === 'topbar' ? 'logo-row' : 'logo'">
            <div :class="variant === 'topbar' ? 'logo-box' : 'logo-icon'">
                <i
                    class="ti ti-flame"
                    style="color: #042c53"
                    :style="{
                        fontSize: variant === 'topbar' ? '18px' : '20px',
                    }"
                    aria-hidden="true"
                ></i>
            </div>
            <div v-if="variant === 'topbar'">
                <div class="logo-name">{{ companyName }}</div>
                <div class="logo-sub">{{ tagline }}</div>
            </div>
            <div v-else class="logo-text">
                {{ companyName }}
                <span class="logo-sub">{{ tagline }}</span>
            </div>
        </div>

        <button
            class="nav-toggle"
            type="button"
            :aria-expanded="mobileOpen"
            aria-label="Buka menu navigasi"
            @click="mobileOpen = !mobileOpen"
        >
            <i
                class="ti"
                :class="mobileOpen ? 'ti-x' : 'ti-menu-2'"
                aria-hidden="true"
            ></i>
        </button>

        <div
            :class="variant === 'topbar' ? 'nav-pills' : 'nav-links'"
            :data-open="mobileOpen"
        >
            <Link
                :href="home()"
                :class="{ active: active === 'home' }"
                @click="mobileOpen = false"
                >Beranda</Link
            >
            <Link
                :href="services()"
                :class="{ active: active === 'services' }"
                @click="mobileOpen = false"
                >Layanan</Link
            >
            <Link
                :href="portfolio()"
                :class="{ active: active === 'portfolio' }"
                @click="mobileOpen = false"
                >Proyek</Link
            >
            <Link
                v-if="variant === 'hero'"
                :href="about()"
                :class="{ active: active === 'about' }"
                @click="mobileOpen = false"
                >Sertifikasi</Link
            >
            <Link
                :href="about()"
                :class="{ active: active === 'about' }"
                @click="mobileOpen = false"
                >Tentang</Link
            >
            <Link
                :href="contact()"
                :class="
                    variant === 'topbar'
                        ? { active: active === 'contact' }
                        : 'nav-cta'
                "
                @click="mobileOpen = false"
            >
                {{ variant === 'topbar' ? 'Kontak' : 'Hubungi Kami' }}
            </Link>
        </div>
    </nav>
</template>

<style scoped>
.topbar {
    background: #042c53;
    padding: 14px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    flex-wrap: wrap;
}
.logo-row {
    display: flex;
    align-items: center;
    gap: 10px;
}
.logo-box {
    width: 32px;
    height: 32px;
    background: #ef9f27;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.logo-name {
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 15px;
    color: #fff;
    letter-spacing: 0.3px;
    line-height: 1.1;
}
.logo-sub {
    font-size: 9px;
    color: rgba(255, 255, 255, 0.5);
    letter-spacing: 2px;
    text-transform: uppercase;
}
.nav-pills {
    display: flex;
    gap: 20px;
}
.nav-pills :deep(a) {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    font-size: 12.5px;
    font-weight: 500;
}
.nav-pills :deep(a.active) {
    color: #ef9f27;
}

.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 32px;
    border-bottom: 0.5px solid rgba(255, 255, 255, 0.12);
    position: relative;
    z-index: 2;
    flex-wrap: wrap;
}
.logo {
    display: flex;
    align-items: center;
    gap: 10px;
}
.logo-icon {
    width: 36px;
    height: 36px;
    background: #ef9f27;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.logo-text {
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 18px;
    color: #fff;
    letter-spacing: 0.5px;
    line-height: 1.1;
}
.logo-text .logo-sub {
    font-weight: 400;
    font-size: 10px;
    color: rgba(255, 255, 255, 0.6);
    letter-spacing: 2px;
    text-transform: uppercase;
    display: block;
}
.nav-links {
    display: flex;
    gap: 24px;
}
.nav-links :deep(a) {
    color: rgba(255, 255, 255, 0.75);
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    letter-spacing: 0.5px;
    transition: color 0.2s;
}
.nav-links :deep(a:hover) {
    color: #ef9f27;
}
.nav-links :deep(a.active) {
    color: #ef9f27;
}
.nav-links :deep(a.nav-cta) {
    background: #ef9f27;
    color: #042c53 !important;
    padding: 7px 16px;
    border-radius: 4px;
    font-weight: 600 !important;
}

.nav-toggle {
    display: none;
    background: rgba(255, 255, 255, 0.08);
    border: none;
    color: #fff;
    width: 36px;
    height: 36px;
    border-radius: 6px;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    cursor: pointer;
    flex-shrink: 0;
}

@media (max-width: 768px) {
    .navbar,
    .topbar {
        padding: 14px 20px;
    }
    .nav-toggle {
        display: flex;
    }
    .nav-links,
    .nav-pills {
        display: none;
        flex-direction: column;
        align-items: stretch;
        gap: 4px;
        width: 100%;
        order: 3;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 0.5px solid rgba(255, 255, 255, 0.12);
    }
    .nav-links[data-open='true'],
    .nav-pills[data-open='true'] {
        display: flex;
    }
    .nav-links :deep(a),
    .nav-pills :deep(a) {
        padding: 10px 4px;
        font-size: 14px;
    }
    .nav-links :deep(a.nav-cta) {
        text-align: center;
        margin-top: 6px;
    }
}
</style>
