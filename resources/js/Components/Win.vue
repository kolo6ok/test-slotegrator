<template>
    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">
            <h4 class="text-lg font-medium leading-6 text-gray-900">{{ win.name }}</h4>
            <p class="mt-1 text-sm text-gray-600">
                Статус: {{ win.statusName }}
            </p>

        </dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <div class="flex items-center content-center h-full">

                <JetButton v-if="isToTake"
                           class="ml-4"
                           :type="'button'"
                           :class="{ 'opacity-25': isSend }"
                           :disabled="isSend"
                           :click="onTake"
                >
                    Забрать приз
                </JetButton>

                <JetButton v-if="isToScore"
                           class="ml-4"
                           :type="'button'"
                           :class="{ 'opacity-25': isSend }"
                           :disabled="isSend"
                           :click="onScore"
                >
                    Перевести в баллы
                </JetButton>

                <JetDangerButton v-if="isToTake"
                                 class="ml-4"
                                 :class="{ 'opacity-25': isSend }"
                                 :disabled="isSend"
                                 :click="onReject"
                >
                    Отказаться
                </JetDangerButton>
            </div>
        </dd>
    </div>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetDangerButton from '@/Jetstream/DangerButton'

    export default {

        name: "Win",

        props: ['win'],

        components: {
            JetButton,
            JetDangerButton
        },

        data() {
            return {
                isSend: false,
            }
        },

        computed: {
            isToScore() {
                return this.win.type === 3 && this.win.status === 10
            },
            isToTake() {
                return this.win.status === 10
            },
        },

        methods: {
            loadResponse(data) {
                this.win.status = data.status
                this.win.statusName = data.statusName
                if ([202,303].indexOf(data.status) !== -1){
                    this.$parent.$props.balance = data.userBalance
                }
            },
            onScore() {
                let $this = this
                $this.isSend = true
                axios.post(this.route('wins.toScore'),{ id: this.win.id })
                    .then((res) => {
                        this.loadResponse(res.data.data)
                        $this.isSend = false
                    })
            },
            onTake() {
                let $this = this
                $this.isSend = true
                axios.post(this.route('wins.take'),{ id: this.win.id })
                    .then((res) => {
                        this.loadResponse(res.data.data)
                        $this.isSend = false
                    })
            },
            onReject() {
                let $this = this
                $this.isSend = true
                axios.post(this.route('wins.reject'),{ id: this.win.id })
                    .then((res) => {
                        this.loadResponse(res.data.data)
                        $this.isSend = false
                    })
            },

        }
    }
</script>

<style scoped>

</style>
