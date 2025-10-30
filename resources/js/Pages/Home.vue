<script setup>
import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue';
import { ref } from 'vue'

const props = defineProps({
    posts: Array,
    users: Array
})

const forms = reactive({})

props.posts.forEach(post => {
    forms[post.id] = useForm({
        post_id: post.id,
        content: ''
    })
})

const submit = (post_id) => {
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

    <Head title=" | Home" />
    <div class="flex mb-10 gap-3">
        <div class="flex flex-col gap-5">
            <section v-for="post in posts" class="w-max h-96">
                <div class="mt-8 bg-white lg:flex lg:items-start justify-between min-w-5xl h-full pr-6 rounded-xl">
                    <img class="object-cover max-w-md rounded-xl h-72 lg:h-96" :src="'storage/' + post.image_path"
                        alt="">
                    <div class="mt-6 lg:w-1/2 lg:mt-0  flex flex-col relative h-full py-5">
                        <Link href="" class="flex items-center gap-x-2 ">
                        <img v-if="post.user.avatar" class="object-cover w-8 h-8 rounded-full"
                            :src="'storage/' + post.user.avatar" alt="">
                        <img v-else class="object-cover w-8 h-8 rounded-full" :src="'storage/default.png'" alt="">
                        <div>
                            <h1 class="text-base font-semibold text-gray-700">{{
                                post.user.username }}
                            </h1>
                            <p class="text-xs text-gray-500">Uploaded at {{
                                formatDateTime(post.created_at) }}</p>
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
                                    <p class="text-sm text-gray-500">
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

                            <form @submit.prevent="submit(post.id)" class="flex w-full items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-300">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                                </svg>
                                <textarea placeholder="comment.." v-model="forms[post.id].content"
                                    class="block  mt-2 w-full  placeholder-gray-400/70 rounded-lg border border-gray-200 bg-white px-4 h-12 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40"></textarea>
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
        <div class="mt-8 bg-white h-max p-5 min-w-xs rounded-xl">
            <h2 class="font-medium">Other People</h2>
            <div v-for="user in users" class="max-h-48 overflow-auto w-full">
                <Link v-if="user.id != $page.props.auth.user.id" :href="route('user.index', user.username)"
                    class="flex gap-x-2 mt-3 ml-2 items-start">
                <img v-if="user.avatar" class="object-cover w-7 h-7 rounded-full shrink-0"
                    :src="'storage/' + user.avatar" alt="">
                <img v-else class="object-cover w-8 h-8 rounded-full" :src="'storage/default.png'" alt="">
                <div>
                    <h1 class="text-sm font-semibold text-gray-700">{{
                        user.username }}
                    </h1>
                    <p class="text-sm text-gray-500">
                        Since {{ formatDate(user.created_at) }}
                    </p>
                </div>
                </Link>
            </div>
        </div>
    </div>
</template>
