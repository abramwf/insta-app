<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    caption: null,
    image_path: null,
    preview: null
})

const change = (e) => {
    form.image_path = e.target.files[0]
    form.preview = URL.createObjectURL(e.target.files[0])
}

const cancel = () => {
    form.image_path = null
    form.preview = null
}

const submit = () => {
    form.post(route('post.store'))
}

</script>
<template>
    <div class="flex">
        <section class="dark:bg-gray-900 w-max h-96">
            <div
                class="mt-8 bg-white lg:flex lg:items-start justify-between max-w-5xl min-w-4xl h-full pr-6 rounded-xl">
                <img class="object-cover min-w-md rounded-xl h-72 lg:h-96" v-if="form.preview" :src="form.preview"
                    alt="">
                <div class="object-cover w-full rounded-xl border-gray-200 border-2 border-dashed h-72 lg:h-96" v-else>
                </div>
                <div class="mt-6 lg:w-1/2 lg:mt-0  flex flex-col relative h-full py-5 px-5">
                    <div class="flex items-center gap-x-2 ">
                        <img class="object-cover w-8 h-8 rounded-full" :src="'storage/' + $page.props.auth.user.avatar"
                            alt="">
                        <div>
                            <h1 class="text-base font-semibold text-gray-700 capitalize dark:text-white">{{
                                $page.props.auth.user.username }}
                            </h1>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $page.props.auth.user.email }}</p>
                        </div>
                    </div>
                    <form @submit.prevent="submit" class="border-t border-t-gray-100 mt-2 w-full">
                        <div class="flex items-end gap-2">
                            <label for="dropzone-file"
                                class="flex w-full items-center px-3 py-3 mx-auto mt-6 text-center bg-white border-2 border-dashed rounded-lg cursor-pointer border-gray-200 dark:bg-gray-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-300 dark:text-gray-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>


                                <h2 class="mx-3 text-gray-400" v-if="form.image_path?.name">{{ form.image_path.name }}
                                </h2>
                                <h2 class="mx-3 text-gray-400" v-else>Upload Image</h2>
                                <input id="dropzone-file" type="file" class="hidden" @input="change" />
                            </label>
                            <button v-if="form.preview"
                                class="items-center cursor-pointer text-gray-500 size-6 self-center" @click="cancel">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="size-5 text-gray-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>

                            </button>
                        </div>
                        <div class="relative flex items-center mt-2">
                            <span class="absolute">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <textarea placeholder="lorem..." v-model="form.caption"
                                class="block  mt-2 w-full px-11 placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-gray-200 bg-white h-28 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300"></textarea>
                        </div>
                        <button type="submit" :disabled="form.processing"
                            class="w-full px-6 mt-3 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-500 rounded-lg hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                            Post
                        </button>
                    </form>
                </div>
            </div>
        </section>
        <div></div>
    </div>
</template>
