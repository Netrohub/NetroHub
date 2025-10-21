import { Card } from "@/components/ui/card";
import { Smartphone, Laptop, Watch, Headphones, Camera, Gamepad2 } from "lucide-react";
import { useLanguage } from "@/contexts/LanguageContext";

const categories = [
  { name: "Electronics", icon: Smartphone, count: 245 },
  { name: "Computers", icon: Laptop, count: 189 },
  { name: "Wearables", icon: Watch, count: 127 },
  { name: "Audio", icon: Headphones, count: 156 },
  { name: "Photography", icon: Camera, count: 98 },
  { name: "Gaming", icon: Gamepad2, count: 213 },
];

const CategoryGrid = () => {
  const { t } = useLanguage();
  
  return (
    <section className="py-16 relative">
      <div className="container mx-auto px-4">
        <div className="mb-12 text-center space-y-3">
          <h2 className="text-4xl font-black bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
            {t('browseByPlatform')}
          </h2>
          <p className="text-foreground/60 text-lg">{t('choosePlatform')}</p>
        </div>
        
        <div className="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-6">
          {categories.map((category) => {
            const Icon = category.icon;
            return (
              <Card
                key={category.name}
                className="glass-card cursor-pointer p-6 text-center group hover:scale-105 transition-all duration-300"
              >
                <div className="mb-4 flex justify-center">
                  <div className="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-primary/20 to-accent/20 border border-primary/30 group-hover:border-primary/50 group-hover:scale-110 transition-all duration-300">
                    <Icon className="h-7 w-7 text-primary group-hover:text-accent transition-colors" />
                  </div>
                </div>
                <h3 className="mb-2 font-bold text-foreground group-hover:text-primary transition-colors">{category.name}</h3>
                <p className="text-sm text-muted-foreground font-medium">{category.count} items</p>
              </Card>
            );
          })}
        </div>
      </div>
    </section>
  );
};

export default CategoryGrid;
