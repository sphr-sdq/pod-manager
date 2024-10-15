<template>
    <div class="relative w-[500px] h-[500px] overflow-hidden bg-white rounded-3xl">
        <canvas
            ref="canvasRef"
            class="absolute top-0 left-0 w-full h-full"
        ></canvas>
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-white">
            <h1 class="text-6xl font-bold mb-4">Welcome to Our Site</h1>
            <p class="text-2xl">Discover amazing things with us</p>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue';

export default {
    name: 'OptimizedBallBackground',
    setup() {
        const canvasRef = ref(null);
        let animationFrameId = null;

        // Customizable parameters
        const params = {
            // Number of balls
            ballCount: 10,
            // Minimum and maximum ball radius
            minRadius: 50,
            maxRadius: 150,
            // Ball speed range
            minSpeed: 0.5,
            maxSpeed: 2,
            // Color parameters
            baseHue: Math.random() * 360,  // Base hue for the color scheme
            saturation: 70,
            minLightness: 20,
            maxLightness: 40,
            // Blur amount
            blurPx: 40,
            // Background fade speed (lower = longer trails)
            fadeAlpha: 0.01
        };

        // Function to generate a random color
        const generateColor = () => {
            const hue = (params.baseHue + Math.random() * 60 - 30 + 360) % 360;
            const lightness = params.minLightness + Math.random() * (params.maxLightness - params.minLightness);
            return `hsl(${hue}, ${params.saturation}%, ${lightness}%)`;
        };

        onMounted(() => {
            const canvas = canvasRef.value;
            const ctx = canvas.getContext('2d');

            const resizeCanvas = () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            };

            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            // Create balls
            const balls = Array.from({length: params.ballCount}, () => ({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                radius: params.minRadius + Math.random() * (params.maxRadius - params.minRadius),
                dx: (Math.random() - 0.5) * (params.maxSpeed - params.minSpeed) + params.minSpeed,
                dy: (Math.random() - 0.5) * (params.maxSpeed - params.minSpeed) + params.minSpeed,
                color: generateColor()
            }));

            const animate = () => {
                // Create a semi-transparent background for trailing effect
                ctx.fillStyle = `rgba(255, 255, 255, ${params.fadeAlpha})`;
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                balls.forEach(ball => {
                    // Move the ball
                    ball.x += ball.dx;
                    ball.y += ball.dy;

                    // Bounce off edges
                    if (ball.x + ball.radius > canvas.width || ball.x - ball.radius < 0) ball.dx = -ball.dx;
                    if (ball.y + ball.radius > canvas.height || ball.y - ball.radius < 0) ball.dy = -ball.dy;

                    // Draw the ball
                    ctx.beginPath();
                    ctx.arc(ball.x, ball.y, ball.radius, 0, Math.PI * 2);
                    ctx.fillStyle = ball.color;
                    ctx.fill();
                });

                animationFrameId = requestAnimationFrame(animate);
            };

            // Apply blur effect
            canvas.style.filter = `blur(${params.blurPx}px)`;

            animate();
        });

        onUnmounted(() => {
            if (animationFrameId) {
                cancelAnimationFrame(animationFrameId);
            }
            window.removeEventListener('resize', resizeCanvas);
        });

        return {
            canvasRef
        };
    }
};
</script>
