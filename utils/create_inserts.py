from random import randint
import re

categories: dict[str, int] = {}
idxCat = 1


class Product:
    def __init__(self, id: int, name: str, img: str, desc: str, price: float, categories: list[int]) -> None:
        self.id = id
        self.name = name
        self.img = img
        self.desc = desc
        self.price = price
        self.categories = categories
        self.country = randint(1, 4)

    def get_insert(self):
        return f"""INSERT INTO producto (id, nombre, precio, descripcion, img_path, id_pais)
VALUES ({self.id}, '{self.name}', {self.price}, '{self.desc}', '{self.img}', {self.country});"""

    def get_categories_insert(self):
        query = ""
        for cat in self.categories:
            query += f"INSERT INTO producto_categoria (id_producto, id_categoria) VALUES ({self.id}, {cat});\n"
        return query

def find_categories(targets: list[str]) -> list[int]:
    global categories
    global idxCat

    idxs: list[int] = []

    for cat in targets:
        if idx := categories.get(cat):
            idxs.append(idx)
        else:
            categories[cat] = idxCat
            idxs.append(idxCat)
            idxCat += 1

    return idxs


if __name__ == "__main__":
    products: list[Product] = []
    productCount = 1
    with open("./products.txt", "r") as pdfile:
        while True:
            pdimg = pdfile.readline().strip("\n")
            if not pdimg:
                break
            pdname = pdfile.readline().strip("\n").replace("'", "''")
            pddesc = pdfile.readline().strip("\n").replace("'", "''")
            pdprice = pdfile.readline().strip("\n")
            pdprice = float(pdprice)
            pdcategories = list(map(lambda s: re.sub('\s+', '', s), pdfile.readline().strip("\n").split(",")))

            categoriesIdx = find_categories(pdcategories)

            if pdfile.readline().strip("\n").replace(" ", "") != "":
                print("Invalid element.")
                continue

            p = Product(productCount, pdname, pdimg, pddesc, pdprice, categoriesIdx)
            products.append(p)
            productCount += 1

    with open('temp.sql', 'w', encoding='utf8') as inserts_file:

        for cat, idx in categories.items():
            print(f"INSERT INTO categoria (id, nombre) VALUES ({idx}, '{cat}');", file=inserts_file)

        for p in products:
            print(p.get_insert(), file=inserts_file)
            print(p.get_categories_insert(), file=inserts_file)
