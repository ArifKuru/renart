# Renart API – Case Study

Bu proje, [Web sitesi linki](https://arifkuru.com/renart) Renart mücevher koleksiyonu için geliştirilmiş bir RESTful API'dir. API, ürün verilerini sunar ve her bir ürün için dinamik fiyatlandırma, ağırlık ve görsel varyasyon bilgilerini içerir.

## Database Scheme

![Database Scheme](https://github.com/user-attachments/assets/31147f47-0ac7-4238-8f41-40ed8a441c17)


## Live API

- Ürün Listesi: [`https://arifkuru.com/api/products`](https://arifkuru.com/api/products)

## Örnek JSON Yanıtı

```json
{
  "id": 1,
  "name": "Engagement Ring 1",
  "popularityScore": 0.85,
  "weight": 2,
  "price": 396,
  "images": {
    "yellow": {
      "color": "#E6CA97",
      "url": "https://cdn.shopify.com/s/files/1/0484/1429/4167/files/EG085-100P-Y.jpg?v=1696588368"
    },
    "rose": {
      "color": "#E1A4A9",
      "url": "https://cdn.shopify.com/s/files/1/0484/1429/4167/files/EG085-100P-R.jpg?v=1696588406"
    },
    "white": {
      "color": "#D9D9D9",
      "url": "https://cdn.shopify.com/s/files/1/0484/1429/4167/files/EG085-100P-W.jpg?v=1696588402"
    }
  }
}
