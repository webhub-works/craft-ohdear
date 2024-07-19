<template>
  <div class="oh-grid xs:oh-grid-cols-2 oh-gap-4 sm:oh-grid-cols-3 oh-max-w-3xl">

    <div class="oh-flex oh-space-x-3" v-for="metric in metricItems">
      <div class="oh-mt-[5px]">
        <StatusIcon :status="getMetricStatus(metric)"></StatusIcon>
      </div>
      <div>
        <p class="oh-mb-1 oh-font-medium">{{ $t(metric.title) }}</p>
        <p class="oh-text-xl oh-font-mono" :class="getMetricColor(metric).text">{{ formatMetricValue(metric) }}</p>
        <p v-if="showDescription">{{ $t(metric.description) }}</p>
      </div>
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
    StatusIcon
  },
  data() {
    return {
      metricItems: [
        {
          key: 'firstContentfulPaintInMs',
          title: 'First Contenful Paint',
          description: 'First Contentful Paint marks the time at which the first text or image is painted.',
          valueSuffix: 'ms',
          thresholds: {
            bad: 3000,
            ok: 1800,
          }
        }, {
          key: 'largestContentfulPaintInMs',
          title: 'Largest Contenful Paint',
          description: 'Largest Contentful Paint marks the time at which the largest text or image is painted.',
          valueSuffix: 'ms',
          thresholds: {
            bad: 4000,
            ok: 2500,
          }
        }, {
          key: 'totalBlockingTimeInMs',
          title: 'Total Blocking Time',
          description: 'Sum of all time periods between FCP and Time to Interactive, when task length exceeded 50ms, expressed in milliseconds.',
          valueSuffix: 'ms',
          thresholds: {
            bad: 600,
            ok: 200,
          }
        }, {
          key: 'speedIndexInMs',
          title: 'Speed Index',
          description: 'Speed Index shows how quickly the contents of a page are visibly populated.',
          valueSuffix: 'ms',
          thresholds: {
            bad: 5800,
            ok: 3400,
          }
        }, {
          key: 'cumulativeLayoutShift',
          title: 'Cumulative Layout Shift',
          description: 'Cumulative Layout Shift measures the movement of visible elements within the viewport.',
          thresholds: {
            bad: 0.25,
            ok: 0.1,
          }
        }
      ]
    }
  },
  methods: {
    getMetricStatus(metric) {
      const metricValue = this.lighthouseReport[metric.key];
      if (metricValue < metric.thresholds.ok) {
        return 'good';
      }
      if (metricValue < metric.thresholds.bad) {
        return 'ok';
      }
      return 'bad';
    },
    getMetricColor(metric) {
      const metricValue = this.lighthouseReport[metric.key];
      if (metricValue < metric.thresholds.ok) {
        return {
          text: 'oh-text-green-600',
        }
      }
      if (metricValue < metric.thresholds.bad) {
        return {
          text: 'oh-text-orange-500',
        }
      }
      return {
        text: 'oh-text-red-500',
      }
    },
    formatMetricValue(metric) {
      const metricValue = this.lighthouseReport[metric.key];
      return metricValue.toFixed(2) + (metric.valueSuffix || '');
    },
  }
}
</script>
