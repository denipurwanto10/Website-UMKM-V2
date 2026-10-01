from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

# Daftar payload SQL Injection
payloads = [
    "' OR '1'='1",
    "admin'--",
    "' OR 'a'='a",
    "' OR ''='",
    "admin' OR 1=1 --"
]

driver = webdriver.Chrome()
driver.get("http://localhost/skripsi/index.php/auth/form_login")

for payload in payloads:
    try:
        # Buka ulang halaman login setiap percobaan
        driver.get("http://localhost/skripsi/index.php/auth/form_login")

        username = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.ID, "username"))
        )
        password = driver.find_element(By.ID, "password")

        # Masukkan payload
        username.send_keys(payload)
        password.send_keys("bebas")  # password bisa apa saja

        driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()

        try:
            WebDriverWait(driver, 3).until(
                EC.url_contains("dashboard")
            )
            print(f"❌ SQL Injection BERHASIL dengan payload: {payload}")
        except:
            print(f"✅ SQL Injection GAGAL (AMAN) dengan payload: {payload}")

    except Exception as e:
        print(f"⚠️ Error saat testing payload {payload}: {e}")

driver.quit()
