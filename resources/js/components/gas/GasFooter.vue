<script setup lang="ts">
withDefaults(defineProps<{ badges?: string[] }>(), {
    badges: () => ['BPH MIGAS', 'ISO 9001', 'OHSAS 18001'],
});
</script>

<template>
    <div class="footer-strip">
        <div class="footer-text">
            &copy; 2025 Nusantara Gas Energy. Semua hak cipta dilindungi.
        </div>
        <div class="cert-row">
            <span v-for="b in badges" :key="b" class="cpill">{{ b }}</span>
        </div>
    </div>
</template>

<style scoped>
.footer-strip {
    background: #031e3a;
    padding: 11px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.footer-text {
    font-size: 11px;
    color: rgba(255, 255, 255, 0.35);
}
.cert-row {
    display: flex;
    gap: 8px;
}
.cpill {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 1px;
    background: rgba(239, 159, 39, 0.12);
    color: #ef9f27;
    padding: 3px 8px;
    border-radius: 3px;
    border: 0.5px solid rgba(239, 159, 39, 0.25);
}

@media (max-width: 560px) {
    .footer-strip {
        flex-direction: column;
        gap: 8px;
        text-align: center;
        padding: 12px 20px;
    }
    .cert-row {
        flex-wrap: wrap;
        justify-content: center;
    }
}
</style>
