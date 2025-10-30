<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'

const props = defineProps({
    posts: Array,
    user: Object
})

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

const forms = reactive({})

props.posts.forEach(post => {
    forms[post.id] = useForm({
        post_id: post.id,
        content: ''
    })
})

const submitComment = (post_id) => {
    const form = forms[post_id]
    form.post(route('comment.store'), { preserveScroll: true, onSuccess: () => form.reset('content') })
}

const loading = ref(false)

function toggleLike(post) {
    loading.value = true
    router.post(route('like.toggle', post.id), {}, {
        preserveScroll: true,
        onSuccess: () => {
            post.is_liked = !post.is_liked
            post.likes_count += post.is_liked ? 1 : -1
        },
        onFinish: () => loading.value = false,
    })
}

const formatDateTime = (date) => {
    return new Date(date).toLocaleString('en-EN', {
        dateStyle: 'medium',
        timeStyle: 'short'
    })
}

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-EN', {
        dateStyle: 'medium',
    })
}


</script>

<template>

    <Head title=" | Profile" />
    <div class="flex mb-10 mt-8 gap-3">
        <div class="flex flex-col gap-5">
            <section v-for="post in posts" class="w-max h-96">
                <div class="bg-white lg:flex lg:items-start justify-between min-w-4xl h-full pr-6 rounded-xl">
                    <img class="object-cover max-w-md rounded-xl h-72 lg:h-96" :src="'storage/' + post.image_path"
                        alt="">
                    <div class="mt-6 lg:w-1/2 lg:mt-0  flex flex-col relative h-full py-5 pl-6">
                        <Link href="" class="flex items-center gap-x-2 ">
                        <img v-if="post.user.avatar" class="object-cover w-8 h-8 rounded-full"
                            :src="'storage/' + post.user.avatar" alt="">
                        <img v-else class="object-cover w-8 h-8 rounded-full" :src="'storage/default.png'" alt="">
                        <div>
                            <h1 class="text-base font-semibold text-gray-700">{{
                                post.user.username }}
                            </h1>
                            <p class="text-xs text-gray-500">Uploaded at {{
                                formatDateTime(post.created_at) }}
                            </p>
                        </div>
                        </Link>
                        <div class="border-b border-b-gray-100 pb-2">
                            <p class="mt-3 text-sm text-gray-500 md:text-sm">
                                {{ post.caption }}
                            </p>
                        </div>
                        <div class="mt-1 max-h-48 overflow-auto w-full">
                            <div v-for="comment in post.comments" class="flex gap-x-2 mt-3 ml-2 items-start">
                                <img v-if="comment.user.avatar" class="object-cover w-7 h-7 rounded-full shrink-0"
                                    :src="'storage/' + comment.user.avatar" alt="">
                                <img v-else class="object-cover w-8 h-8 rounded-full" :src="'storage/default.png'"
                                    alt="">

                                <div>
                                    <h1 class="text-sm font-semibold text-gray-700">{{
                                        comment.user.username }}
                                    </h1>
                                    <p class="text-sm text-gray-500 ">
                                        {{ comment.content }}
                                    </p>
                                </div>
                            </div>

                        </div>

                        <div class="absolute w-full bottom-3 flex items-center gap-4">
                            <button @click="toggleLike(post)" :disabled="loading" class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer"
                                    :class="post.is_liked ? 'text-red-400' : 'text-gray-400'">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                                <p v-if="post.likes_count > 0" class="text-gray-400">{{ post.likes_count }}</p>
                            </button>

                            <form @submit.prevent="submitComment(post.id)" class="flex w-full items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-300">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                                </svg>
                                <textarea placeholder="comment..." v-model="forms[post.id].content"
                                    class="block  mt-2 w-full  placeholder-gray-400/70  rounded-lg border border-gray-200 bg-white px-4 h-12 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40"></textarea>
                                <button type="submit" class="cursor-pointer" :disabled="forms[post.id].processing">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="flex items-start gap-3">
            <form enctype="multipart/form-data" @submit.prevent="submit"
                class="flex items-start gap-x-4 bg-white p-5 rounded-xl min-w-xs">
                <div v-if="!isEditProfile">
                    <img v-if="user.avatar" class="object-cover size-28 rounded-full shrink-0"
                        :src="'storage/' + user.avatar" alt="">
                    <img v-else class="object-cover size-28 rounded-full shrink-0" :src="'storage/default.png'" alt="">
                </div>
                <div v-else-if="form.preview">
                    <button type="button" class="items-center cursor-pointer text-gray-500 size-6 self-center"
                        @click="cancel">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-5 text-gray-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <img class="object-cover size-28 rounded-full shrink-0" :src="form.preview" alt="">
                </div>
                <label v-else for="avatar"
                    class="cursor-pointer size-28 rounded-full shrink-0  border-2 border-dashed border-gray-200">
                    <input type="file" name="avatar" id="avatar" class="hidden" @input="change">
                </label>

                <div>
                    <h1 v-if="!isEditProfile" class="text-xl font-semibold text-gray-700">
                        {{ user.username }}</h1>
                    <div v-else class="flex gap-2">
                        <input class="border border-gray-400 rounded-md p-1" name="username" v-model="form.username" />

                        <button type="submit" :disabled="form.processing"
                            class="w-full p-1 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-500 rounded-lg hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                            Update
                        </button>
                    </div>
                    <small v-if="form.errors.username">{{ form.errors.username }}</small>
                    <small v-if="form.errors.avatar">{{ form.errors.avatar }}</small>
                    <div>
                        <p class="text-base text-gray-500">Since {{ formatDate(user.created_at) }}
                        </p>
                        <h2 class="bg-blue-400 font-medium mt-2 px-3 py-1 rounded-md text-blue-50 w-max text-xs">
                            <span class="text-xl">{{ user.posts_count }}</span> Post
                        </h2>
                    </div>
                </div>
            </form>
            <button @click="editProfile" v-if="!isEditProfile && user.id == $page.props.auth.user.id">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6 text-gray-400 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
            </button>
            <button @click="editProfile" v-if="isEditProfile && user.id == $page.props.auth.user.id">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6 text-gray-400 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>

            </button>
        </div>
    </div>
</template>
