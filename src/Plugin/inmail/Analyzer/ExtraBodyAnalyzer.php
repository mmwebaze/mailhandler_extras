<?php
namespace Drupal\mailhandler_extras\Plugin\inmail\Analyzer;

use Drupal\inmail\DefaultAnalyzerResult;
use Drupal\inmail\Plugin\inmail\Analyzer\AnalyzerBase;
use Drupal\inmail\MIME\MimeMessageInterface;
use Drupal\inmail\ProcessorResultInterface;

/**
 * An extra message body analyzer.
 *
 * @ingroup analyzer
 *
 * This analyzer works with a message body processed by other analyzers in the
 * queue or with a original message body in case there are no body-related
 * analyzer. As of now, it is very primitive in its features. The only thing it
 * does is stripe content-type declaration within the message header away and leave
 * the plain text body message.
 *
 * @Analyzer(
 *   id = "extra_body",
 *   label = @Translation("Extra Body Analyzer")
 * )
 */
class ExtraBodyAnalyzer extends AnalyzerBase
{
    /**
     * {@inheritdoc}
     */
    public function analyze(MimeMessageInterface $message, ProcessorResultInterface $processor_result) {
        $result = $processor_result->getAnalyzerResult();
        $this->analyzeBody($message, $result);
    }
    /**
     * Analyzes the message body and updates it.
     *
     * @param \Drupal\inmail\MIME\MimeMessageInterface $message
     *   A mail message to be analyzed.
     * @param \Drupal\inmail\DefaultAnalyzerResult $result
     *   The analyzer result.
     */
    protected function analyzeBody(MimeMessageInterface $message, DefaultAnalyzerResult $result) {
        $body = $result->getBody() ?: $message->getPlainText();
        $filteredBody = explode('quoted-printable', $body);

        if (count($filteredBody) > 1){
            $result->setBody(explode('--', $filteredBody[0])[0].$filteredBody[1]);
        }
        else{
            $result->setBody($body);
        }
    }
}