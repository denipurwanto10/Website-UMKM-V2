from selenium import webdriver

# Pakai Chrome
driver = webdriver.Chrome()

driver.get("https://www.google.com")
print("Judul halaman:", driver.title)

driver.quit()
