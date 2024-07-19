<template>
  <div class="oh-grid oh-grid-cols-2 sm:oh-grid-cols-4 oh-gap-4 oh-max-w-[360px] sm:oh-max-w-[496px] oh-mb-6"
       v-if="lighthouseReport">
    <div class="oh-my-4"
         v-for="score in ['performanceScore', 'accessibilityScore', 'bestPracticesScore', 'seoScore']">

      <div class="oh-text-green-600 oh-relative oh-w-28 oh-h-28 oh-mx-auto">

        <div class="oh-absolute oh-inset-0 oh-flex oh-items-center oh-justify-center oh-text-xl">
            <span class="oh-z-10 oh-font-mono" :class="getCircularChartColor(lighthouseReport[score]).text">{{
                lighthouseReport[score]
              }}</span>
          <div class="oh-absolute oh-inset-0 oh-m-4 oh-rounded-full"
               :class="getCircularChartColor(lighthouseReport[score]).fill"></div>
        </div>

        <svg viewBox="0 0 36 36" class="oh-absolute oh-inset-0 oh-z-10 circular-chart">
          <path class="circle" :class="getCircularChartColor(lighthouseReport[score]).stroke" d="M18 2.0845
            a 15.9155 15.9155 0 0 1 0 31.831
            a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#444" stroke-width="1"
                :stroke-dasharray="`${lighthouseReport[score]}, 100`"></path>
        </svg>
      </div>

      <div class="oh-text-center oh-font-medium">{{ $t(score) }}</div>

    </div>

    <div class="oh-flex oh-space-x-4" v-if="showDescription">
        <span class="oh-flex oh-items-center oh-space-x-1">
          <StatusIcon status="bad"></StatusIcon>
          <span class="oh-whitespace-nowrap oh-text-sm oh-font-mono oh-mt-1">0-49</span>
        </span>
      <span class="oh-flex oh-items-center oh-space-x-1">
          <StatusIcon status="ok"></StatusIcon>
          <span class="oh-whitespace-nowrap oh-text-sm oh-font-mono oh-mt-1">50-89</span>
        </span>
      <span class="oh-flex oh-items-center oh-space-x-1">
          <StatusIcon status="good"></StatusIcon>
          <span class="oh-whitespace-nowrap oh-text-sm oh-font-mono oh-mt-1">90-100</span>
        </span>
    </div>

  </div>
</template>

<script>
import StatusIcon from "./StatusIcon.vue";

export default {
  props: {
    showDescription: {
      type: Boolean,
      default: false,
    },
    lighthouseReport: {
      type: Object,
      required: true,
    }
  },
  components: {
    StatusIcon,
  },
  methods: {
    getCircularChartColor(value) {
      if (value < 50) {
        return {
          fill: 'oh-bg-red-200',
          stroke: 'oh-stroke-red-400',
          text: 'oh-text-red-500'
        };
      }
      if (value < 90) {
        return {
          fill: 'oh-bg-orange-200',
          stroke: 'oh-stroke-orange-400',
          text: 'oh-text-orange-500'
        };
      }
      return {
        fill: 'oh-bg-green-100',
        stroke: 'oh-stroke-green-500',
        text: 'oh-text-green-600'
      };
    }
  }
}
</script>

<style scoped>
.circular-chart {
  display: block;
  margin: 10px auto;
  max-width: 80%;
  max-height: 250px;
}

.circle {
  fill: none;
  stroke-width: 2.8;
  stroke-linecap: round;
  animation: progress 1s cubic-bezier(.8, 0, .4, 1) forwards;
}

@keyframes progress {
  0% {
    stroke-dasharray: 0 100;
  }
}
</style>
