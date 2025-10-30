<script setup>
import Auth from '../../Layouts/Auth.vue';
import { useForm } from '@inertiajs/vue3';
defineOptions({ layout: Auth })

const form = useForm({
    username: null,
    email: null,
    password: null,
    password_confirmation: null,
    avatar: null,
    preview: null
})

const change = (e) => {
    form.avatar = e.target.files[0]
    form.preview = URL.createObjectURL(e.target.files[0])
}

const cancel = () => {
    form.avatar = null
    form.preview = null
}


const submit = () => {
    form.post(route('register'), {
        onError: () => form.reset("password", "password_confirmation")
    })
}
</script>

<template>

    <Head title=" | Register" />
    <section class="bg-white">
        <div class="container flex items-center justify-center min-h-screen px-6 mx-auto">
            <form @submit.prevent="submit" class="w-full max-w-md">
                <div class="flex justify-center mx-auto">
                    <div class="flex justify-center mx-auto">
                        <h1 class="font-semibold text-2xl"><span
                                class="border-b-2 py-0.5 pr-1 border-blue-800 text-blue-700 italic">Insta</span><span
                                class="font-normal text-3xl text-blue-800">/</span><span
                                class="border-t-2 py-0.5 pl-1 border-blue-800 text-blue-700 italic">App</span></h1>
                    </div>
                </div>

                <div class="flex items-center justify-center mt-6">
                    <Link :href="route('login.index')"
                        class="w-1/3 pb-4 font-medium text-center text-gray-500 capitalize border-b">
                    Login
                    </Link>

                    <a :href="route('register.index')"
                        class="w-1/3 pb-4 font-medium text-center text-gray-800 capitalize border-b-2 border-blue-500 ">
                        Register
                    </a>
                </div>

                <div class="relative flex items-center mt-8">
                    <span class="absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>

                    <input type="text" v-model="form.username" name="username"
                        class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 focus:border-blue-400  focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                        placeholder="Username">
                </div>
                <small v-if="form.errors.username">{{ form.errors.username }}</small>

                <div class="flex items-end gap-2">
                    <label for="dropzone-file"
                        class="flex w-full items-center px-3 py-3 mx-auto mt-6 text-center bg-white border-2 border-dashed rounded-lg cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>

                        <h2 class="mx-3 text-gray-400" v-if="form.avatar?.name">{{ form.avatar.name }}</h2>
                        <h2 class="mx-3 text-gray-400" v-else>Upload Avatar</h2>
                        <input id="dropzone-file" type="file" class="hidden" @input="change" />
                    </label>
                    <img class="object-cover size-12 rounded-full bg-slate-300 shrink-0" v-if="form.preview"
                        :src="form.preview" alt="">
                    <div class="object-cover size-12 rounded-full shrink-0 border-2 border-dashed" v-else>
                    </div>
                    <button v-if="form.preview" type="button" @click="cancel"
                        class="items-center cursor-pointer text-gray-500 size-6 self-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-5 text-gray-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>

                    </button>
                </div>
                <small v-if="form.errors.avatar">{{ form.errors.avatar }}</small>

                <div class="relative flex items-center mt-6">
                    <span class="absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>

                    <input type="email" v-model="form.email" name="email"
                        class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 focus:border-blue-400  focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                        placeholder="Email address">
                </div>
                <small v-if="form.errors.email">{{ form.errors.email }}</small>

                <div class="relative flex items-center mt-4">
                    <span class="absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>

                    <input type="password" v-model="form.password" name="password"
                        class="block w-full px-10 py-3 text-gray-700 bg-white border rounded-lg focus:border-blue-400  focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                        placeholder="Password">
                </div>
                <small v-if="form.errors.password">{{ form.errors.password }}</small>

                <div class="relative flex items-center mt-4">
                    <span class="absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>

                    <input type="password" v-model="form.password_confirmation" name="password_confirmation"
                        class="block w-full px-10 py-3 text-gray-700 bg-white border rounded-lg focus:border-blue-400  focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                        placeholder="Confirm Password">
                </div>
                <small v-if="form.errors.password_confirmation">{{ form.errors.password_confirmation }}</small>

                <div class="mt-6">
                    <button type="submit" :disabled="form.processing"
                        class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-500 rounded-lg hover:bg-blue-400 focus:outline-none focus:ring">
                        Register
                    </button>

                    <div class="mt-6 text-center ">
                        <Link :href="route('login.index')" class="text-sm text-blue-500 hover:underline">
                        Already have an account?
                        </Link>
                    </div>
                </div>
            </form>
        </div>
    </section>
</template>
