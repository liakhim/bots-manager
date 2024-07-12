<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    user_projects: {
        type: Object
    }
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <pre>
                        {{user_projects}}
                    </pre>
                    <ul>
                        <li>
                            <Link :href="route('dashboard.create.page')"  method="get">
                                Create
                            </Link>
                        </li>
                        <li v-for="project of user_projects">
                            <Link :href="route('dashboard.project', project.id)"  method="get">
                                {{project.id}}
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
