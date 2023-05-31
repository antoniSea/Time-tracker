<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
    timeEntries: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(['reload']);

const running = ref(false);
const time = ref(0);
let intervalId = null;
let reloadIntervalId = null;

onMounted(() => {
    if (props.timeEntries.length > 0) {
        time.value = props.timeEntries[0].timeSpent * 1000;

        running.value = true;

        intervalId = setInterval(() => {
            time.value += 10;
        }, 10);
    }

    reloadIntervalId = setInterval(() => {
        emit('reload');
    }, 4000);
});

onUnmounted(() => {
    clearInterval(intervalId);
    clearInterval(reloadIntervalId);
});

const formatTime = computed(() => {
    const seconds = Math.floor(time.value / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);

    return `${pad(hours)}:${pad(minutes % 60)}:${pad(seconds % 60)}`;
});

const start = () => {
    running.value = true;
    intervalId = setInterval(() => {
        time.value += 10;
    }, 10);

    axios.post(route('time-entries.start-timer'))
        .then(response => {
            console.log(response.data);
        })
        .catch(error => {
            console.log(error);
        });
};

const stop = () => {
    running.value = false;
    clearInterval(intervalId);
    time.value = 0;

    axios.post(route('time-entries.close-timer'))
        .then(response => {
            console.log(response.data);
        })
        .catch(error => {
            console.log(error);
        });
};

const reset = () => {
    running.value = false;
    time.value = 0;
    clearInterval(intervalId);
};

const pad = (value) => {
    return String(value).padStart(2, '0');
};
</script>

<template>
  <div class="stopwatch">
    <div class="display">
      {{ formatTime }}
    </div>
    <div class="controls">
      <button @click="start" v-if="!running" class="btn-start">Start</button>
      <button @click="stop" v-if="running" class="btn-stop">Stop</button>
    </div>
  </div>
</template>

<style scoped>
.stopwatch {
  text-align: center;
}

.display {
  font-size: 48px;
  margin-bottom: 20px;
}

.controls button {
  margin: 5px;
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 4px;
  cursor: pointer;
}

.btn-start {
  background-color: #4299e1;
  color: #fff;
}

.btn-stop {
  background-color: #e53e3e;
  color: #fff;
}
</style>
