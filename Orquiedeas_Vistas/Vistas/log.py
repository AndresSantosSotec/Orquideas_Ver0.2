from selenium import webdriver

# Configuración del driver para Chrome
driver = webdriver.Chrome()

# Navegar al formulario de registro
driver.get("http://localhost:8000/registro")

# Completar el formulario
driver.find_element_by_name("nombre").send_keys("Orquídea Phalaenopsis")
driver.find_element_by_name("origen").send_keys("Guatemala")
driver.find_element_by_name("registrar").click()

# Verificar que la planta aparece en el listado
assert "Orquídea Phalaenopsis" in driver.page_source

# Cerrar el navegador
driver.quit()
