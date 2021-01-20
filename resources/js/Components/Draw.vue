<template>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg ">

        <div class="flex items-center content-center ">
            <JetButton v-show="draw == null"
                       class="ml-4"
                       :type="'button'"
                       :class="{ 'opacity-25': isSend }"
                       :disabled="isSend"
                       :click="onGetDraw"
            >
                Новая игра
            </JetButton>


            <JetDangerButton v-show="draw !== null"
                             class="ml-4"
                             :class="{ 'opacity-25': isSend }"
                             :disabled="isSend"
                             :click="onPlay"
            >
                Разыграть
            </JetDangerButton>

            <div v-show="winSlot !== null"> Ваш выигрыш: {{ winSlot.name }}</div>
        </div>
    </div>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import DialogModal from "@/Jetstream/DialogModal";

    export default {
        name: "Draw",

        components: {
            DialogModal,
            JetButton,
            JetDangerButton
        },

        data() {
            return {
                isSend: false,
                draw: null,
                winSlot: null
            }
        },

        methods: {
            onGetDraw() {
                let $this = this
                $this.draw = null
                $this.isSend = true
                axios.get(this.route('draw.get'))
                    .then((res) => {
                        $this.draw = res.data
                        $this.isSend = false
                    })
            },
            onPlay() {
                let $this = this
                $this.isSend = true
                axios.post(this.route('draw.play'),{ key: this.draw.key })
                    .then((res) => {
                        $this.draw = null
                        $this.winSlot = res.data
                        $this.isSend = false
                    })
            }
        }

    }
</script>

<style scoped>

</style>
