import React from 'react'
import { Bar } from "react-chartjs-2"

const BarChart = () => {

  return (
    <div>
    <Bar
      data = {{
        labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin'],
        datasets: [{
          label: 'Impressions',
          data: [1000, 400, 100, 500, 200, 140],
          backgroundColor: ['blue'],
        }]
      }}
      height={1}
      width={2}
      options={{
        maintainAspectRatio: true,
    }}
  />
  </div>
)
}

export default BarChart
