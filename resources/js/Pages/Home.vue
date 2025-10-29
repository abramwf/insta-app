<script setup>
defineProps({
    posts: Object
})
</script>
<template>
    <div class="flex mb-10">
        <div class="flex flex-col gap-5">
            <section v-for="post in posts" class="dark:bg-gray-900 w-max h-96">
                <div class="mt-8 bg-white lg:flex lg:items-start justify-between max-w-5xl h-full pr-6 rounded-xl">
                    <img class="object-cover max-w-md rounded-xl h-72 lg:h-96" :src="'storage/' + post.image_path"
                        alt="">
                    <div class="mt-6 lg:w-1/2 lg:mt-0  flex flex-col relative h-full py-5">
                        <Link href="" class="flex items-center gap-x-2 ">
                        <img class="object-cover w-8 h-8 rounded-full" :src="'storage/' + $page.props.auth.user.avatar"
                            alt="">
                        <div>
                            <h1 class="text-base font-semibold text-gray-700 capitalize dark:text-white">{{
                                $page.props.auth.user.username }}
                            </h1>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $page.props.auth.user.email }}</p>
                        </div>
                        </Link>
                        <div>
                            <p class="mt-3 text-sm text-gray-500 dark:text-gray-300 md:text-sm">
                                {{ post.caption }}
                            </p>
                        </div>
                        <div class="border-t border-t-gray-100 mt-2 max-h-48 overflow-auto w-full">
                            <div class="flex gap-x-2 mt-3 ml-2 items-start">
                                <img class="object-cover w-7 h-7 rounded-full shrink-0"
                                    :src="'storage/' + $page.props.auth.user.avatar" alt="">
                                <div>
                                    <h1 class="text-sm font-semibold text-gray-700 capitalize dark:text-white">{{
                                        $page.props.auth.user.username }}
                                    </h1>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure veritatis sint
                                        autem
                                        nesciunt,
                                        laudantium quia tempore delect
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure veritatis sint
                                        autem
                                        nesciunt,
                                        laudantium quia tempore delect
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure veritatis sint
                                        autem
                                        nesciunt,
                                        laudantium quia tempore delect
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-x-2 mt-3 ml-2 items-start">
                                <img class="object-cover w-7 h-7 rounded-full shrink-0"
                                    :src="'storage/' + $page.props.auth.user.avatar" alt="">
                                <div>
                                    <h1 class="text-sm font-semibold text-gray-700 capitalize dark:text-white">{{
                                        $page.props.auth.user.username }}
                                    </h1>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure veritatis sint
                                        autem
                                        nesciunt,
                                        laudantium quia tempore delect
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure veritatis sint
                                        autem
                                        nesciunt,
                                        laudantium quia tempore delect
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure veritatis sint
                                        autem
                                        nesciunt,
                                        laudantium quia tempore delect
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="absolute w-full bottom-3 flex items-center gap-4">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6 text-gray-300">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                            </svg>
                            <div class="flex w-full items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-300">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                                </svg>
                                <textarea placeholder="lorem..."
                                    class="block  mt-2 w-full  placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-gray-200 bg-white px-4 h-12 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div></div>
    </div>
</template>
