const apiUrl = 'https://provinces.open-api.vn/api';

// Lấy danh sách tỉnh/thành phố
const getProvinces = async () => {
  const response = await fetch(`${apiUrl}/p`);
  const provinces = await response.json();
  return provinces;
}

// Lấy danh sách quận/huyện của một tỉnh/thành phố
const getDistricts = async (provinceId) => {
  
  const response = await fetch(`${apiUrl}/p/${provinceId}?depth=2`);
  const districts = await response.json();
  return districts;
}

// Lấy danh sách xã/phường của một quận/huyện
const getWards = async (districtId) => {
  const response = await fetch(`${apiUrl}/d/${districtId}?depth=2`);
  const wards = await response.json();
  return wards;
}

// Đưa danh sách tỉnh/thành phố vào thẻ select
const renderProvinces = async () => {
  const provinces = await getProvinces();
  const citySelect = document.querySelector('#city');

  provinces.forEach(province => {
    const option = document.createElement('option');
    option.value = province.code;
    option.textContent = province.name;
    citySelect.appendChild(option);
  });

  citySelect.addEventListener('change', async () => {
    // Xóa tất cả các tùy chọn của thẻ select quận/huyện và xã/phường
    document.querySelector('#district').innerHTML = '<option value="">-- Chọn quận/huyện --</option>';
    document.querySelector('#ward').innerHTML = '<option value="">-- Chọn xã/phường --</option>';

    const provinceId = citySelect.value;
    const districts = await getDistricts(provinceId);
    const districts1 = districts.districts.map(district => {
        return {
          "name": district.name,
          "code": district.code,
          "division_type": district.division_type,
          "codename": district.codename,
          "province_code": district.province_code,
          "wards": district.wards
        };
      });
    // Đưa danh sách quận/huyện vào thẻ select quận/huyện
    const districtSelect = document.querySelector('#district');
    districts1.forEach(district => {
    const option = document.createElement('option');
    option.value = district.code;
    option.textContent =  district.name;
    districtSelect.appendChild(option);
    });
    districtSelect.addEventListener('change', async () => {
        // Xóa tất cả các tùy chọn của thẻ select xã/phường
        document.querySelector('#ward').innerHTML = '<option value="">-- Chọn xã/phường --</option>';
      
        const districtId = districtSelect.value;
        const wards = await getWards(districtId);
        console.log(wards)
        const wards1 = wards.wards.map(ward => {
            return {
              "name": ward.name,
              "code": ward.code,
              "division_type": ward.division_type,
              "codename": ward.codename,
              "province_code": ward.province_code

            };
          });
          console.log(wards1)
        // Đưa danh sách xã/phường vào thẻ select xã/phường
        const wardSelect = document.querySelector('#ward');
        wards1.forEach(ward => {
          const option = document.createElement('option');
          option.value = ward.code;
          option.textContent = ward.name;
          wardSelect.appendChild(option);
        });
      });
    });
}

renderProvinces();

