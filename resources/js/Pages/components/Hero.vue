<template>
    <div class="relative w-full overflow-hidden" :style="{ height }">
        <!-- Increased padding wrapper for better coverage -->
        <div class="absolute inset-0 p-[80px]">
            <!-- Canvas container with increased negative margin -->
            <div class="relative w-[calc(100%+300px)] h-[calc(100%+300px)] m-[-150px]">
                <canvas
                    ref="canvasRef"
                    class="w-full h-full"
                ></canvas>
            </div>
        </div>
        <!-- Content slot for hero content -->
        <div class="absolute inset-0 z-10">
            <slot></slot>
        </div>
    </div>
</template>

<script>
import {ref, onMounted, onUnmounted} from 'vue';

export default {
    name: 'HeroBackground',
    props: {
        height: {
            type: String,
            default: '100vh'
        },
        containerClass: {
            type: String,
            default: ''
        }
    },
    setup() {
        const canvasRef = ref(null);
        let animationFrameId = null;
        let resizeObserver = null;

        // Adjusted parameters for better coverage
        const params = {
            ballCount: 10,
            minRadius: 50,
            maxRadius: 150,
            minSpeed: 0.5,
            maxSpeed: 2,
            baseHue: 44,
            saturation: 0,
            minLightness: 20,
            maxLightness: 40,
            blurPx: 40,
            fadeAlpha: 0.01,
            padding: 80 // Increased padding for better coverage
        };

        const generateColor = () => {
            const hue = (params.baseHue + Math.random() * 60 - 30 + 360) % 360;
            const lightness = params.minLightness + Math.random() * (params.maxLightness - params.minLightness);
            return `hsl(${hue}, ${params.saturation}%, ${lightness}%)`;
        };

        onMounted(() => {
            const canvas = canvasRef.value;
            const ctx = canvas.getContext('2d');

            const updateCanvasSize = () => {
                const rect = canvas.parentElement.getBoundingClientRect();
                // Add extra size to ensure full coverage
                canvas.width = rect.width;
                canvas.height = rect.height;

                // Set initial background
                ctx.fillStyle = 'rgba(100, 100, 100, 1)';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
            };

            resizeObserver = new ResizeObserver(updateCanvasSize);
            resizeObserver.observe(canvas.parentElement);

            updateCanvasSize();

            // Initialize balls with adjusted boundaries
            const balls = Array.from({length: params.ballCount}, () => {
                const radius = params.minRadius + Math.random() * (params.maxRadius - params.minRadius);
                return {
                    x: params.padding + radius + Math.random() * (canvas.width - 2 * (radius + params.padding)),
                    y: params.padding + radius + Math.random() * (canvas.height - 2 * (radius + params.padding)),
                    radius,
                    dx: (Math.random() - 0.5) * (params.maxSpeed - params.minSpeed) + params.minSpeed,
                    dy: (Math.random() - 0.5) * (params.maxSpeed - params.minSpeed) + params.minSpeed,
                    color: generateColor()
                };
            });

            const animate = () => {
                // Semi-transparent overlay to create trail effect
                ctx.fillStyle = `rgba(0, 0, 0, ${params.fadeAlpha})`;
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                balls.forEach(ball => {
                    ball.x += ball.dx;
                    ball.y += ball.dy;

                    // Adjust bounce boundaries with increased padding
                    const effectivePadding = params.padding + ball.radius;
                    if (ball.x + ball.radius > canvas.width - params.padding || ball.x - ball.radius < params.padding) {
                        ball.dx = -ball.dx;
                        ball.x = Math.max(effectivePadding, Math.min(canvas.width - effectivePadding, ball.x));
                    }
                    if (ball.y + ball.radius > canvas.height - params.padding || ball.y - ball.radius < params.padding) {
                        ball.dy = -ball.dy;
                        ball.y = Math.max(effectivePadding, Math.min(canvas.height - effectivePadding, ball.y));
                    }

                    ctx.beginPath();
                    ctx.arc(ball.x, ball.y, ball.radius, 0, Math.PI * 2);
                    ctx.fillStyle = ball.color;
                    ctx.fill();
                });

                animationFrameId = requestAnimationFrame(animate);
            };

            canvas.style.filter = `blur(${params.blurPx}px)`;
            animate();
        });

        onUnmounted(() => {
            if (animationFrameId) {
                cancelAnimationFrame(animationFrameId);
            }
            if (resizeObserver) {
                resizeObserver.disconnect();
            }
        });

        return {
            canvasRef
        };
    }
};
</script>
