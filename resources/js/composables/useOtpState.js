import { ref } from 'vue'

export function useOtpState() {
    const timeLeft = ref(null);
    const minutes = ref(null);
    const seconds = ref(null);
    const isError = ref(false);
    let timer = null

    const startTimer = (time) => {
        stopTimer();
        isError.value= true;
        timeLeft.value = Math.ceil(time);

        timer = setInterval(() => {

            // Calculate minutes and seconds
            minutes.value = Math.floor(timeLeft.value / 60);
            seconds.value = timeLeft.value % 60;

            // Pad with zeros if needed
            minutes.value = minutes.value < 10 ? `0${minutes.value}` : minutes.value.toString();
            seconds.value = seconds.value < 10 ? `0${seconds.value}` : seconds.value.toString();




            timeLeft.value--
            if (timeLeft.value <= 0) {
                stopTimer()
            }
        }, 1000)
    }

    const stopTimer = () => {
        if (timer) {
            clearInterval(timer);
            timer = null;
        }
        isError.value = false;
        timeLeft.value = null;
        minutes.value = null;
        seconds.value = null;
    };


    return {
        // State
        timeLeft,
        minutes,
        seconds,
        isError,

        // Methods
        startTimer,
        stopTimer,

    }
}
