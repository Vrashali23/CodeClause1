const apiKey = "c2afb4b6cada42d8bde122030250808";  // 🔁 Replace this with your WeatherAPI key

async function getWeather() {
  const cityInput = document.getElementById("cityInput");
  const city = cityInput.value.trim();
  const resultDiv = document.getElementById("weatherResult");

  if (!city) {
    resultDiv.innerHTML = "❗ Please enter a city name.";
    return;
  }

  resultDiv.innerHTML = "🔄 Loading...";

  const url = `https://api.weatherapi.com/v1/current.json?key=${apiKey}&q=${encodeURIComponent(city)}`;

  console.log("Fetching:", url);  // Debug line

  try {
    const response = await fetch(url);

    if (!response.ok) {
      throw new Error("API request failed");
    }

    const data = await response.json();

    if (data.error) {
      throw new Error(data.error.message);
    }

    const output = `
      <h2>${data.location.name}, ${data.location.country}</h2>
      <p>🌡️ Temperature: ${data.current.temp_c}°C</p>
      <p>🌥️ Condition: ${data.current.condition.text}</p>
      <p>💨 Wind: ${data.current.wind_kph} kph</p>
      <img src="https:${data.current.condition.icon}" alt="Weather Icon" />
    `;

    resultDiv.innerHTML = output;
  } catch (error) {
    console.error("❌ Error:", error.message);
    resultDiv.innerHTML = `<span style="color:red;">❌ ${error.message}</span>`;
  }
}
