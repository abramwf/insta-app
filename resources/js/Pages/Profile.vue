<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const form = useForm({
    username: null,
    avatar: null,
    preview: null
})

const isEditProfile = ref(false)

function editProfile() {
    if (!isEditProfile.value) {
        isEditProfile.value = true
    } else {
        form.username = null
        form.avatar = null
        form.preview = null
        isEditProfile.value = false
    }
}

const change = (e) => {
    form.avatar = e.target.files[0]
    form.preview = URL.createObjectURL(e.target.files[0])
    console.log(form.avatar)
}

const cancel = () => {
    form.avatar = null
    form.preview = null
}

const submit = () => {
    router.post(route('user.update'), {
        _method: 'put',
        username: form.username,
        avatar: form.avatar
    }, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            isEditProfile.value = false
        },
    })
}


</script>

<template>
    <div class="flex mb-10">
        <div class="flex items-start gap-3">
            <form enctype="multipart/form-data" @submit.prevent="submit"
                class="flex items-start gap-x-4 bg-white p-5 rounded-xl">
                <img v-if="!isEditProfile" class="object-cover size-36 rounded-full shrink-0"
                    :src="'storage/' + $page.props.auth.user.avatar" alt="">
                <div v-else-if="form.preview">
                    <button type="button" class="items-center cursor-pointer text-gray-500 size-6 self-center"
                        @click="cancel">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-5 text-gray-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <img class="object-cover size-36 rounded-full shrink-0" :src="form.preview" alt="">
                </div>
                <label v-else for="avatar"
                    class="cursor-pointer size-36 rounded-full shrink-0  border-2 border-dashed border-gray-200">
                    <input type="file" name="avatar" id="avatar" class="hidden" @input="change">
                </label>

                <div>
                    <h1 v-if="!isEditProfile" class="text-xl font-semibold text-gray-700 capitalize dark:text-white">
                        {{ $page.props.auth.user.username }}</h1>
                    <div v-else class="flex gap-2">
                        <input class="border border-gray-400 rounded-md p-1 dark:text-white" name="username"
                            v-model="form.username" />

                        <button type="submit" :disabled="form.processing"
                            class="w-full p-1 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-500 rounded-lg hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                            Update
                        </button>
                    </div>
                    <small v-if="form.errors.username">{{ form.errors.username }}</small>
                    <small v-if="form.errors.avatar">{{ form.errors.avatar }}</small>
                    <p class="text-base text-gray-500 dark:text-gray-400">{{ $page.props.auth.user.email }}</p>
                </div>
            </form>
            <button @click="editProfile" v-if="!isEditProfile">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6 text-gray-400 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
            </button>
            <button @click="editProfile" v-else>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6 text-gray-400 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>

            </button>
        </div>
        <div class="flex flex-col gap-5">

        </div>
    </div>
</template>
