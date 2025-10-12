#!/bin/bash
# sync_context.sh
# Her 5 dakikada bir bağlamı güncelle

while true; do
    echo "🔄 Bağlam güncelleniyor..."
    
    # Git'ten son değişiklikleri al
    git log --oneline -5 >> CONVERSATION_LOG.md
    
    # Timestamp ekle
    echo "---" >> CONVERSATION_LOG.md
    echo "Son Güncelleme: $(date)" >> CONVERSATION_LOG.md
    
    echo "✅ Güncellendi!"
    sleep 300  # 5 dakika bekle
done

