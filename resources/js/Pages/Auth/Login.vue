<script setup>
import Auth from '../../Layouts/Auth.vue';
import { useForm } from '@inertiajs/vue3';

defineOptions({ layout: Auth })

const form = useForm({
    email: null,
    password: null
})

const submit = () => {
    form.post(route("login"), {
        onError: () => form.reset("password")
    })
}
</script>

<template>
    <section class="bg-white dark:bg-gray-900">
        <div class="container flex items-center justify-center min-h-screen px-6 mx-auto">
            <form @submit.prevent="submit" class="w-full max-w-md">
                <div class="flex justify-center mx-auto">
                    <h1 class="font-semibold text-2xl"><span
                            class="border-b-2 py-0.5 pr-1 border-blue-800 text-blue-700 italic">Insta</span><span
                            class="font-normal text-3xl text-blue-800">/</span><span
                            class="border-t-2 py-0.5 pl-1 border-blue-800 text-blue-700 italic">App</span></h1>
                </div>

                <div class="flex items-center justify-center mt-6">
                    <Link :href="route('login.index')"
                        class="w-1/3 pb-4 font-medium text-center text-gray-800 capitalize border-b-2 border-blue-500 dark:border-blue-400 dark:text-white">
                    Login
                    </Link>

                    <Link :href="route('register.index')"
                        class="w-1/3 pb-4 font-medium text-center text-gray-500 capitalize border-b dark:border-gray-400 dark:text-gray-300 ">
                    Register
                    </Link>
                </div>

                <div class="relative flex items-center mt-6">
                    <span class="absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>

                    <input type="email" name="email" v-model="form.email"
                        class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                        placeholder="Email address">
                </div>
                <small v-if="form.errors.email">{{ form.errors.email }}</small>
                <div class="relative flex items-center mt-4">
                    <span class="absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>

                    <input type="password" name="password" v-model="form.password"
                        class="block w-full px-10 py-3 text-gray-700 bg-white border rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                        placeholder="Password">
                </div>
                <small v-if="form.errors.password">{{ form.errors.password }}</small>

                <div class="mt-6">
                    <button :disabled="form.processing"
                        class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-500 rounded-lg hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                        Login
                    </button>

                    <div class="mt-6 text-center ">
                        <Link :href="route('register.index')"
                            class="text-sm text-blue-500 hover:underline dark:text-blue-400">
                        Don't have an account?
                        </Link>
                    </div>
                </div>
            </form>
        </div>
    </section>
</template>
