import { computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export function usePageQuery() {
    const route = useRoute();
    const router = useRouter();

    const actualPage = computed<number>({
        get() {
            const page = route.query.page;

            if (typeof page !== 'string') {
                return 1;
            }

            if (page.match(/^\d+$/)?.length !== 1) {
                router.push({ path: route.fullPath, query: { page: 1 } });
                return 1;
            }

            return parseInt(page);
        },
        set(value) {
            router.push({ path: route.fullPath, query: { page: value } });
        },
    });

    return { actualPage };
}
