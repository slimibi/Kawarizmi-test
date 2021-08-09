import { Bar } from "react-chartjs-2";
import React, { useState } from "react";
import axios from "axios";

const Chart = () => {
  const [impressionsMay, setImpressionsMay] = useState();
  const [impressionsJune, setImpressionsJune] = useState();
  const [clicksMay, setClicksMay] = useState();
  const [clicksJune, setClicksJune] = useState();
  axios.get("http://localhost:3001/api/res/").then((res) => {
    console.log(res.data);
    setImpressionsMay(res.data.sumImpressionsMay);
    setImpressionsJune(res.data.sumImpressionsJune);
    setClicksMay(res.data.sumClickMay);
    setClicksJune(res.data.sumClickJune);
  });

  return (
    <div>
      <Bar
        data={{
          labels: ["May", "June"],
          datasets: [
            {
              label: "Impressions",
              data: [impressionsMay, impressionsJune],
              backgroundColor: ["#0A1F5B", "#0A1F5B"],
              borderWidth: 1,
            },
          ],
        }}
      />
      <Bar
        data={{
          labels: ["May", "June"],
          datasets: [
            {
              label: "Clicks",
              data: [clicksMay, clicksJune],
              backgroundColor: ["#E93323", "#E93323"],
              borderWidth: 1,
            },
          ],
        }}
      />
    </div>
  );
};

export default Chart;
